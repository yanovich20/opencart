<?
class ModelCarsImporter extends Model
{
    public function importFile($filename,$categoryId)
    {
        $file = fopen($filename,"r");
        $head = fgetcsv($file,1000000,';');
        $allMarks = $this->db->query("SELECT manufacturer_id, name FROM ".DB_PREFIX."manufacturer")->rows;
        $allOptionsDescriptions = $this->db->query("SELECT option_id, option_value_id,name FROM ".DB_PREFIX."option_value_description")->rows;
        $this->prepareMap();
        
        while(($fileLine = fgetcsv($file,100000,';'))!==false){
            $markIndex = $this->getIndexByTextValue($head,"Марка");
            $markName = $fileLine[intval($markIndex)];
            $manufacturerId= $this->getManufacturerId($allMarks,trim($markName));
            if($manufacturerId == -1)
            {
                $this->db->query("INSERT ".DB_PREFIX."manufacturer(name) VALUES('".$markName."')");
                $manufacturerId = $this->db->getLastId();
                $allMarks[]=array("manufacturer_id" => $manufacturerId,"name"=>$markName);
            }
            
            $modelIndex = $this->getIndexByTextValue($head,"Модель");
            $model = $fileLine[$modelIndex];
            
            $priceIndex = $this->getIndexByTextValue($head,"Цена");
            $price = $fileLine[$priceIndex];
            
            $descriptionIndex =$this->getIndexByTextValue($head,"Описание");
            $description = $fileLine[$descriptionIndex];
            
            $this->db->query("INSERT ".DB_PREFIX."product(manufacturer_id,price,model) VALUES('".$manufacturerId."','".$price."','".$model."')");
            $productId =$this->db->getLastId();
            $this->db->query("INSERT ".DB_PREFIX."product_description(product_id,description,language_id,name) VALUES(".$productId.",'".$description."',1,'".$markName." ".$model."')");
            $this->db->query("INSERT ".DB_PREFIX."product_to_category(product_id,category_id) VALUES(".$productId.",".$categoryId.")");
            for($index=0;$index<count($head);$index++)
            {
                $field = $this->getRecordMappedValue($head[$index]);
                if(!$field)
                    continue;
                $fieldValue = $fileLine[$index];
                switch($field["type"])
                {
                    case "optionstring":
                        $this->db->query("INSERT ".DB_PREFIX."product_option(product_id, option_id,value) VALUES(".$productId.",".$field["option_id"].",'".$fieldValue."')");
                        break;
                    case "optionselect":
                        $this->db->query("INSERT ".DB_PREFIX."product_option(product_id, option_id) VALUES(".$productId.",".$field["option_id"].")");
                        $productOptionId = $this->db->getLastId();
                        $optionValueId = $this->getOptionValueId($allOptionsDescriptions,$fieldValue,$field["option_id"]);
                        if($optionValueId !="")
                            $this->db->query("INSERT ".DB_PREFIX."product_option_value(product_option_id,product_id,option_id,option_value_id) VALUES("
                            .$productOptionId.",".$productId.",".$field["option_id"].",".$optionValueId.")");
                        break;
                }
            }
        }
        fclose($file);
    }
    public function getOptionValueId($array,$optionName,$optionId)
    {
        foreach($array as $option)
        {
            if($option["name"]==$optionName&& $option["option_id"]==$optionId)
            {
                return $option["option_value_id"];
            }
        }
        return "";
    }

    public function getManufacturerId($array,$text)
    {
        foreach($array as $value)
        {
            if($value["name"] == $text)
            {
                return $value["manufacturer_id"];
            }
        }
        return -1;
    }
    public function getIndexByTextValue($array,$textValue)
    {
        foreach($array as $key=>$value)
        {
            if(trim($value)==$textValue)
            {
                return $key;
            }
        }
        return -1;
    }
    private array $map;
    private array $mapExclude;

    private function prepareMap(){
        $gearboxOptionId = $this->getOptionId("Коробка передач");                                        
        $bodytypeOptionId= $this->getOptionId("Тип кузова");
        $yearOptionId = $this->getOptionId("Год выпуска");
        $fuelOptionId=$this->getoptionId("Тип топлива");
        $mileageOptionId = $this->getOptionId("Пробег");
        $transmissionOptionId = $this->getOptionId("Привод");
        $artNumberOptionId = $this->getOptionId("Артикул");

        $this->map =array(
        "Тип топлива"=>array("type"=>"optionselect","option_id"=>$fuelOptionId),
        "Коробка передач"=>array("type"=>"optionselect","option_id"=>$gearboxOptionId),
        "Тип кузова"=>array("type"=>"optionselect","option_id"=>$bodytypeOptionId),
        "Привод"=>array("type"=>"optionselect","option_id"=>$transmissionOptionId),
        "Год выпуска"=>array("type"=>"optionstring","option_id"=>$yearOptionId),
        "Артикул"=>array("type"=>"optionstring","option_id"=>$artNumberOptionId),
        );
        $this->mapExclude =["Марка","Модель","Цена","Описание"];
    }
    private function getRecordMappedValue(string $name){
        if(!in_array($name,$this->mapExclude))
            return $this->map[$name];
    }
    private function getOptionId($name)
    {
        $option = $this->db->query("SELECT option_id FROM ".DB_PREFIX."option_description WHERE name = '".$name."'");
        return $option->row["option_id"];
    }
}
?>