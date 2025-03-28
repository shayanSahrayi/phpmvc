<?php

namespace App\Core;

use PDO;
use Exception;
use PDOException;

use App\Core\HasOne;
use Error;

use function PHPSTORM_META\type;

class Model
{

    public $connection;
    protected $table = '';
    protected $premary_key = 'id';
    private $fetch = [PDO::FETCH_DEFAULT => PDO::FETCH_OBJ];
    private $op = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::FETCH_DEFAULT => PDO::FETCH_OBJ];

    private $wheres = [];
    private $orWheres = [];
    private $order = [];
    private $limit;
    private $selects = [];
    public $results = [];
    public $data = [];
    protected $joins = [];
    protected $offset;
    protected $addCondition = [];
    protected $groups;
    protected $whereRow = [];
    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:dbhost=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_USER_NAME, DB_PASS, $this->op);
        } catch (PDOException $e) {
            ddd($e);
        }
    }

    public function all()
    {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->query($query);

        // return $result;
        return new  Collection((array)$result);
    }
    public function find($id)
    {
        $this->where('id', $id);
        $stmt = $this->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function delete($id)
    {
        // if (empty($id)) throw new Exception("please enter ", 1);
        // $select = $this->where('id', $id)->first();
        // $data = [
        //     'id' => $select->id,
        //     'full_name' => $select->first_name . ":" . $select->last_name,
        //     'phone' => $select->phone,
        //     'created_at' => $select->created_at,
        //     'delete' => date('Y-M-d H:i:s'),
        // ];
        // $json[] =json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        // $old=file_get_contents("log.json");

        // array_push($json,$old);
        //   ddd(gettype(json_decode($old)));

        // $sql = "DELETE FROM {$this->table} WHERE id=?";
        // $stmt = $this->connection->prepare($sql);
        // $stmt->execute([$id]);
        // $f[] = $data;

        // $old = json_decode(file_get_contents("log.json")) ?? null;
        // if (is_null($old)) {
        // } else {
        //     $file = file_put_contents("log.json", json_encode($f, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        //     array_push($old, $f);
        // }
        // $file = file_put_contents("log.json", json_encode($f));
        if (empty($id)) {
            throw new Error("لطفا ایدی را ارسال کنید", 1);
        }
        try {
            $sql = "DELETE FROM `{$this->table}` WHERE id = ? ;";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            return $stmt;
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function softDelte($id)
    {

        // if (empty($id)) throw new Exception("please enter id", 1);
        try {

            $sql = "UPDATE `{$this->table}` SET deleted_at=now() WHERE id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);

            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function whereRow($query)
    {
        $this->addCondition = [$query];

        return $this;
    }
    public function whereIn(){

    }

    // public function where($column, $operator, $value = null)
    // {

    //     if (func_num_args() === 2) {
    //         $value = $operator;
    //         $operator = "=";
    //     }
    //     // $newVlue=
    //     if(explode(" ",$value)){
    //         $operator=" ";
    //     }
    //     $this->wheres[] = [
    //         'column' => $column,
    //         'operator' => $operator,
    //         'value' => $value,
    //         'boolean' => 'AND',
    //     ];
    //     return $this;
    // }
    public function where($column, $operator, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = "=";
        }

        $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'boolean' => 'AND',
        ];

        return $this;
    }

    public function orWhere($column, $operator, $value = null)
    {
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = "=";
        }
        $this->orWheres[] =     $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'boolean' => 'OR',
        ];
        return $this;
    }
    public function whereNull($column)
    {
        $this->addCondition[] =  "`$column` IS NULL";
        return $this;
    }
    public function whereNotNull($column)
    {
        $this->addCondition[] = [`$column IS NOT NULL`];
        return $this;
    }
    public function query(string $query, $data = null)
    {

        $stmt = $this->connection->prepare($query);
        if (!empty($data)) {
            $stmt->execute($data);
        } else {
            $stmt->execute();
        }

        if ($stmt->rowCount() > 1) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        return $stmt->fetch(PDO::FETCH_OBJ);

        // if($stmt->rowCount())



    }
    public function create(array $data)
    {
         $field = implode(", ", array_keys($data));
        $placeholders = ':' . implode(", :", array_keys($data));
        try {
            $query = "INSERT INTO {$this->table} ($field) VALUES($placeholders)";
            $stmt = $this->connection->prepare($query);
            // ddd($query);
            $stmt->execute($data);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function update(array $data)
    {
        
        if (empty($data)) {
            throw new Exception("Error Processing Request", 1);
        }
        if (count($this->wheres) > 0) {

            $whereExecute = $this->executeWhere();
            $WhereQuery = $whereExecute['sql'];
            $params = $whereExecute['params'];
        }
        foreach ($data as $key => $value) {
            $setBind[] = $key;
            $setValue[] = $value;
        }
        $bind = implode("=?,", $setBind);
        $sql = "UPDATE {$this->table} SET $bind=? $WhereQuery";
        // $bindValue = array_merge([$setValue, $params[0]]);
        
        array_push($setValue, ...$params);
 
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($setValue);

        return  $stmt;
    }
    public function createOrupdate($condition,$data){
     
 
        $record=$this->where(array_keys($condition)[0],array_values($condition)[0])->first();
        if($record){
            return $this->update($data);
        }
        $all_date=array_merge($data,$condition);
          return $this->create($all_date);
    }

    public function orderBy($coloumn, $direction = "ASC")
    {
        $this->order = compact('coloumn', 'direction');
        return $this;
    }
    public function get()
    {
        $data = $this->execute();
        return $data->fetchAll(PDO::FETCH_OBJ);
    }
    public function first()
    {
        $data = $this->execute();
        return $data->fetch(PDO::FETCH_OBJ);
        // return $this;
    }
    public function latest()
    {

        $this->order = ['coloumn' => 'created_at', 'direction' => 'DESC'];
        return $this;
    }
    public function join($table, $condition, $type = 'INNER')
    {
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }
    private function execute()
    {
        try {

            // ddd($this->selects[1]); 
            $select = !empty($this->selects)
                ? implode(', ', $this->selects)
                : '*';
            $table = $this->table;

            $sql = "SELECT {$select} FROM {$this->table} ";
            if (!empty($this->joins)) {
                $sql .= " " . implode(' ', $this->joins) . ' ';
            }

            $params = [];
            if (count($this->wheres) > 0) {
                $whereExecute = $this->executeWhere($sql);
                $sql = $whereExecute['sql'];
                $params = $whereExecute['params'];
            }
            if (!empty($this->addCondition)) {
                foreach ($this->addCondition as $item => $key)

                    if ($item == 0) {
                        if (count($this->wheres) < 1) {

                            $sql .= "WHERE $key ";
                        } else {
                            $sql .= "AND  $key ";
                        }
                    } else {
                        $sql .= "AND  $key ";
                    }
            }
            //  orderBy  Section
            if (!empty($this->order)) {
                $sql .= " ORDER BY " .  $table . "." . $this->order['coloumn'] . " " . $this->order['direction'];
            }
            if (!empty($this->limit)) {
                $sql .= " LIMIT {$this->limit} ";
            }
            if (!empty($this->offset) || $this->offset == "0") {
                $sql .= " OFFSET $this->offset ";
            }
            if (!empty($this->groups)) {
                $sql .= "GROUP BY $this->groups";
            }
            
             $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            ddd($e->getMessage());
        }
    }
    private function executeWhere($sql = null)
    {
        $clouserWhere = [];
        $params = [];
        foreach ($this->wheres as $index => $where) {
            if ($index == 0) {
                $clouserWhere[] = "{$where['column']} {$where['operator']} ? ";
            } else {
                $clouserWhere[] = " {$where['boolean']}  {$where['column']} {$where['operator']} ? ";
            }
            $params[] = $where['value'];
        }
        $sql .= "WHERE " . implode(' ', $clouserWhere);

        return compact('sql', 'params');
    }

    public function sum($coloumn)
    {
        $this->selects = ['SUM(' . $coloumn . ') as total'];
        $stmt = $this->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }
    public function select($data)
    {

        // $this->selects= $data;
        $this->selects = $data;

        return $this;
    }
    public function take($count): static
    {
        $this->limit = $count;
        return $this;
    }
    public function groupBy($data)
    {
        $this->groups = $data;
        return $this;
    }
    public function reset()
    {
        $this->wheres = [];
        $this->order = [];
        $this->limit = null;
        return $this;
    }

    public function hasOne($related, $forgen = null, $primary = null)
    {

        $foreignKey = ($forgen == null) ? $this->setIdforgen(static::class) : $forgen;

        $primaryKey = ($primary == null) ? $this->premary_key : $primary;

        return new HasOne($this, $related, $foreignKey, $primaryKey);

        // $tabels=new $model();
        // $table=$tabels->where($forgenKey,$primary)->get();


        // return $table;

    }

    private function setIdforgen($model)
    {
        return  strtolower(explode('\\', get_class(new $model))[2]) . "_id";
    }
    public function paginate($page,$order='created_at')
    {
        $clone = static::class;
        // $t = new $clone;
        $t = clone $this;
        $count = $t->select(["COUNT($t->table.id) as count"])->first();
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->limit = $page;
        $this->offset = ceil(($current_page - 1) * $page);

        $this->results = $this->orderBy($order, "DESC")->get();
        $data = [
            'data' => $this->results,
            'current_page' => $current_page,
            'record' => $this->offset,
            'total' => $count->count,
            'pages' => ceil($count->count / $page),
        ];
        return $data;
    }
}
