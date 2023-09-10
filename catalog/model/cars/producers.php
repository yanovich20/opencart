<?
class ModelCarsProducers extends Model
{
    public function getProducers($categoryId)
    {
        $carProducersRows = $this->db->query("SELECT DISTINCT m.name, m.manufacturer_id From ".DB_PREFIX.'product as p left join '.DB_PREFIX.'product_to_category as pc on pc.product_id = p.product_id left join '.DB_PREFIX.'manufacturer as m on p.manufacturer_id = m.manufacturer_id WHERE pc.category_id="'.$categoryId.'"');
        return $carProducersRows->rows;
    }
    public function getProducersAndCount($categoryId)
    {
        $carProducersRows = $this->db->query("SELECT DISTINCT m.name, m.manufacturer_id, COUNT(*) as cManufacturer From ".DB_PREFIX.'product as p left join '.DB_PREFIX.'product_to_category as pc on pc.product_id = p.product_id left join '.DB_PREFIX
        .'manufacturer as m on p.manufacturer_id = m.manufacturer_id WHERE pc.category_id="'.$categoryId.'" group by m.manufacturer_id');
        return $carProducersRows->rows;
    }
}
?>