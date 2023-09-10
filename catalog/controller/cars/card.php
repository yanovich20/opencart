<?
class ControllerCarsCard extends Controller
{
    public function index()
    {
        try{
        $filter = array();
        $filter["isajax"] = $_REQUEST["isajax"];
        $pagination["pageSize"]=2;
        if($filter["isajax"]==1)
        {
            $filter["mark"] =$_REQUEST["mark"];
            $filter["model"]=$_REQUEST["model"];
            $filter["priceFrom"]=$_REQUEST["priceFrom"];
            $filter["priceTo"] = $_REQUEST["priceTo"];
            $filter["fuel"] =$_REQUEST["fuel"];
            $filter["gearbox"]=$_REQUEST["gearbox"];
            $filter["yearFrom"]=$_REQUEST["yearFrom"];
            $filter["yearTo"]=$_REQUEST["yearTo"];

            $sort = array();
            $sort["sortBy"]=$_REQUEST["sortBy"];
            $sort["sortOrder"]=$_REQUEST["sortOrder"];
            
            $pagination["page"]=$_REQUEST["page"];
        }
        else
        {
            $pagination["page"]=1;
        }
        $this->load->model("cars/category");
        $this->load->model("cars/card");
        $carsCategoryId = $this->model_cars_category->getCarsCategory();
        $cars = $this->model_cars_card->getCarsProducts($carsCategoryId,$filter,$sort,$pagination);
        $data["cars"]=$cars["CARS"];
        $carsCount = $cars["TOTAL_COUNT"];
        $numberOfPages =intval($carsCount/$pagination["pageSize"]);
        if($carsCount%$pagination["pageSize"]!=0)
            $numberOfPages++;
        $data["currentPage"]=$pagination["page"];
        $data["numberOfPages"]=$numberOfPages;
        echo "paging is ". print_r($pagination,true);
        if($filter["isajax"]==1)
        {
            $this->response->setOutput($this->load->view('/cars/template/cars/card', $data));
        }
        else
          return $this->load->view('/cars/template/cars/card', $data);
     }
     catch(\Exception $e)
     {
        echo "Произошла ошибка." . $e->getMessage();
     }
    }
}
?>