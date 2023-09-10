<?
    class ControllerCarsModelsFilter extends Controller
    {
        public function index(){
            $producerId = $_REQUEST["producerId"];
            $this->load->model("cars/models");
            $this->load->model("cars/category");
            $carsCategoryId = $this->model_cars_category->getCarsCategory();
            $producerModels = $this->model_cars_models->getModelsByProducer($carsCategoryId,$producerId);
            return $this->response->setOutput(json_encode($producerModels));
        }
    }
?>