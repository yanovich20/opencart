<?
class ModelCarsModels extends Model
{
    public function getModels($categoryId)
    {
        $carModelsRows = $this->db->query("SELECT DISTINCT model From ".DB_PREFIX.'product as p left join '.DB_PREFIX.'product_to_category as pc on pc.product_id = p.product_id WHERE pc.category_id="'.$categoryId.'"');
        return $carModelsRows->rows;
    }
    public function getModelsByProducer($categoryId,$producerId){
        $carModelsRows = $this->db->query("SELECT DISTINCT model From ".DB_PREFIX.'product as p left join '.DB_PREFIX.'product_to_category as pc on pc.product_id = p.product_id WHERE pc.category_id="'.
        $categoryId.'" AND p.manufacturer_id="'.$producerId.'"');
        return $carModelsRows->rows;
    }
}
?>