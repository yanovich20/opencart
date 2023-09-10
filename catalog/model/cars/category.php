<?php
class ModelCarsCategory extends Model
{
    public function getCarsCategory()
    {
        $categoryRow = $this->db->query("SELECT category_id from ".DB_PREFIX."category_description WHERE name = 'Автомобили'");
        $categoryId = $categoryRow->row["category_id"];
        return $categoryId;
    }
}
?>