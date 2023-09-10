<?
class ControllerCarsFooter extends Controller
    {
        public function index(){
            //$data['aside'] = $this->load->controller('cars/aside');
            //$data['footer'] = $this->load->controller('cars/footer');
            //$data['header'] = $this->load->controller('cars/header');
            $data["here"] = "here";
            // Выводим на экран
            return $this->load->view('/cars/template/cars/footer', $data);
        }
    }
    ?>