<?
class ControllerCarsFullpage extends Controller
{
    public function index(){
        try{
        $data['header'] = $this->load->controller('cars/header');
        $data['footer'] = $this->load->controller('cars/footer');
        $data['aside'] = $this->load->controller('cars/aside');
        $data['card'] = $this->load->controller('cars/card');
        return $this->response->setOutput($this->load->view('/cars/template/cars/fullpage', $data));
        }
        catch(\Exception $e)
        {
            echo "Произошла ошибка." . $e->getMessage();
        }
    }
}
?>