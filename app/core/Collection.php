<?php

namespace App\Core;

use function PHPSTORM_META\argumentsSet;

class Collection
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function where($column, $operator, $value = null)
    {

        if (func_num_args() === 2) {
            $value = $operator;
            $operator = "=";
        }

        $filtered = array_filter($this->items, function ($item) use ($column, $operator, $value) {
            //    ddd($item->id,$column);
            switch ($operator) {
                case '=':
                    return $item->$column == $value;

                case '!=':
                    return $item->$column != $value;

                case '>':
                    return $item->$column > $value;

                case '<':
                    return $item->$column < $value;

                case '>=':
                    return $item->$column >= $value;

                case '<=':
                    return $item->$column  <= $value;

                case 'LIKE':
                    return stripos($item[$column], str_replace('%', '', $value)) !== false;

                case 'NOT LIKE':
                    return stripos($item[$column], str_replace('%', '', $value)) === false;

                default:
                    return false;
            }
        });
        return new self(array_values($filtered)); // داده‌های فیلتر شده را به عنوان یک Collection جدید برمی‌گرداند
    }
    public function count()
    {
        return count($this->items);
    }
    public function get()
    {
        return $this->items;
    }
    public function toArray()
    {
        $result = array_map(function ($items) {
            return $items;
        }, $this->items);
        return $result;
    }

    public function filter(callable $callback)
    {
        $filtered = [];
        // اعمال callback برای هر آیتم و اضافه کردن مواردی که شرط را پاس می‌کنند
        foreach ($this->items as $item) {
            if ($callback($item)) {
                $filtered[] = $item;
            }
        }
        // بازگشت یک شیء جدید Collection با داده‌های فیلتر شده
        return new self($filtered);
    }
}
