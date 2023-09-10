<?
class ControllerCarsAside extends Controller
{
    public function index(){
        //$data['aside'] = $this->load->controller('cars/aside');
        $this->load->model("cars/category");
        $this->load->model("cars/models");
        $this->load->model("cars/producers");
        $carsCategoryId = $this->model_cars_category->getCarsCategory();
        $data['carsModels'] = $this->model_cars_models->getModels($carsCategoryId);
        $data['carsProducers'] =$this->model_cars_producers->getProducers($carsCategoryId);
        $data['carsProducersAndCount']=$this->model_cars_producers->getProducersAndCount($carsCategoryId);
               
       // return $this->response->setOutput($this->load->view('/cars/template/cars/aside', $data));
       return $this->load->view('/cars/template/cars/aside', $data);
    }
}
?>