<?
class ModelCarsCard extends Model
{
    private $carsQuery;
    public function getCarsProducts($categoryId,$filter,$sort,$pagination)
    {
/*        $fuelOptionId = 5;
        $carMileageOptionId=14;
        $yearManufacturedOptionId = 13;
        $gearBoxOptionId=15;
        $bodyTypeOptionId=16;*/

        $gearBoxOptionId = $this->getOptionId("Коробка передач");                                        
        $bodyTypeOptionId= $this->getOptionId("Тип кузова");
        $yearManufacturedOptionId = $this->getOptionId("Год выпуска");
        $fuelOptionId=$this->getoptionId("Тип топлива");
        $carMileageOptionId = $this->getOptionId("Пробег");
        $transmissionOptionId = $this->getOptionId("Привод");
        $artNumberOptionId = $this->getOptionId("Артикул");
        $newOptionId = $this->getOptionId("Новинка");

        $this->carsQuery = "SELECT SQL_CALC_FOUND_ROWS proddescr.name as name,proddescr.description as options, p.price as price,p.image as image, m.name as manufacturer, popty.value as year, poptm.value as mileage, p.model as model, optdescrf.name as fuel,optdescrg.name as gearbox,optdescrbt.name as bodytype, popta.value as artnumber,optdescrn.name as new FROM "
        .DB_PREFIX."product as p left join ".DB_PREFIX."manufacturer as m on p.manufacturer_id=m.manufacturer_id left join ". DB_PREFIX. "product_description as proddescr on p.product_id=proddescr.product_id inner join " . DB_PREFIX."product_to_category as pcat on p.product_id = pcat.product_id left join ".DB_PREFIX.
       "product_option as popty on  p.product_id = popty.product_id and popty.option_id='". $yearManufacturedOptionId . "' left join " .DB_PREFIX.
       "product_option as poptm on  p.product_id = poptm.product_id and poptm.option_id='". $carMileageOptionId ."' left join " .DB_PREFIX.
       "product_option as poptf on  p.product_id = poptf.product_id and poptf.option_id='". $fuelOptionId ."' left join " .DB_PREFIX. "product_option_value as poptvf on poptf.product_option_id = poptvf.product_option_id left join ".DB_PREFIX."option_value_description as optdescrf on poptvf.option_value_id = optdescrf.option_value_id left join ".DB_PREFIX.
       "product_option as poptg on  p.product_id = poptg.product_id and poptg.option_id='". $gearBoxOptionId ."' left join " .DB_PREFIX. "product_option_value as poptvg on poptg.product_option_id = poptvg.product_option_id left join ".DB_PREFIX."option_value_description as optdescrg on poptvg.option_value_id = optdescrg.option_value_id left join ".DB_PREFIX. 
       "product_option as popta on  p.product_id = popta.product_id and popta.option_id='". $artNumberOptionId ."' left join " .DB_PREFIX.
       "product_option as poptn on  p.product_id = poptn.product_id and poptn.option_id='". $newOptionId ."' left join " .DB_PREFIX. "product_option_value as poptvn on poptn.product_option_id = poptvn.product_option_id left join ".DB_PREFIX."option_value_description as optdescrn on poptvn.option_value_id = optdescrn.option_value_id left join ".DB_PREFIX.
       "product_option as poptbt on  p.product_id = poptbt.product_id and poptbt.option_id='". $bodyTypeOptionId ."' left join " .DB_PREFIX. "product_option_value as poptvbt on poptbt.product_option_id = poptvbt.product_option_id left join ".DB_PREFIX."option_value_description as optdescrbt on poptvbt.option_value_id = optdescrbt.option_value_id WHERE pcat.category_id=".$categoryId;
       if(!empty($filter["mark"]))
       {
            $this->addFilterSubQuery(" m.manufacturer_id='".$filter["mark"]."'");
       }
       if(!empty($filter["model"]))
       {
            $this->addFilterSubQuery(" p.model='".$filter["model"]."'");
       }
       if(!empty($filter["priceFrom"]))
       {
            $this->addFilterSubQuery(" p.price >'".$filter["priceFrom"]."'");
       }
       if(!empty($filter["priceTo"]))
       {
            $this->addFilterSubQuery(" p.price <'".$filter["priceTo"]."'");
       }
       if(!empty($filter["gearbox"]))
       {
            $this->addFilterSubQuery(" poptvg.option_value_id ='".$filter["gearbox"]."'");
       }
       if(!empty($filter["fuel"]))
       {
            $this->addFilterSubQuery(" poptvf.option_value_id ='".$filter["fuel"]."'");
       }
       if(!empty($filter["yearFrom"]))
       {
             $this->addFilterSubQuery(" popty.value >'".$filter["yearFrom"]."'");
       }
       if(!empty($filter["yearTo"]))
       {
             $this->addFilterSubQuery(" popty.value <'".$filter["yearTo"]."'");
       }

       if(!empty($sort['sortBy']))
       {
            if($sort['sortBy'] =='year')
            {
                $this->carsQuery.=" ORDER BY popty.value ". $sort["sortOrder"];
            }
            if($sort['sortBy']=='price')
            {
                $this->carsQuery.=" ORDER BY p.price ". $sort["sortOrder"];
            }
       }
       $this->carsQuery.= " LIMIT ".($pagination["page"]-1)*$pagination["pageSize"].",".$pagination["pageSize"];
       
       $carsRows = $this->db->query($this->carsQuery);
       $result = array();
       $result["CARS"]=$carsRows->rows;

       $carsTotal = $this->db->query("SELECT FOUND_ROWS() as totalCount");
       $result["TOTAL_COUNT"]=$carsTotal->row['totalCount'];
       return $result;
    }
    public function addFilterSubQuery( $subQuery){
        if(strpos($this->carsQuery,"WHERE")!==false)
        {
            $this->carsQuery .= " AND " .$subQuery;
        }
        else
        {
            $this->carsQuery .= " WHERE ".$subQuery;
        }
    }

    private function getOptionId($name)
    {
        $option = $this->db->query("SELECT option_id FROM ".DB_PREFIX."option_description WHERE name = '".$name."'");
        return $option->row["option_id"];
    }
}
?>