<?php
namespace App\Core;
use App\Core\Model;
class HasOne {
    protected $parent;
    protected $related;
    protected $foreignKey;
    protected $premary_key;

    public function __construct($parent, $related, $foreignKey, $localKey) {
        $this->parent = $parent;
        $this->related = new $related();
        $this->foreignKey = $foreignKey;
        $this->premary_key = $localKey;
        // ddd(  $this->premary_key);
        $this->getResults();
    }
    
    public function getResults() {
        // ساخت کوئری برای دریافت رکورد مرتبط
        
        ddd($this->related->where($this->foreignKey, $this->parent->{$this->premary_key})->first());
    }
}