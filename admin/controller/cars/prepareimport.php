<?
class ControllerCarsPrepareimport extends Controller
{
    public function index(){
        $data["usertoken"]=$this->session->data['user_token'];
        $this->response->setOutput($this->load->view('/cars/import', $data));
    }
}
?>