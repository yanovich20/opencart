<?
class ControllerCarsImport  extends Controller
{
    public function index(){
        try{
        if($_FILES['userfile']['type']!="text/csv")
        {
            echo "Неверный тип файла";
            return;
        }
        $name = DIR_UPLOAD.$_FILES["userfile"]["name"];
        echo "tmp is ". $_FILES["userfile"]["tmp_name"];
        if(move_uploaded_file($_FILES["userfile"]["tmp_name"], $name)!==false)
        {
            $this->load->model("cars/importer");
            $this->load->model("cars/category");
            $categoryId = $this->model_cars_category->getCarsCategory();
            echo $this->model_cars_importer->importFile($name,$categoryId);
        }
        echo "Файл загружен";
    }
    catch(\Exception $e)
    {
        echo "Произошла ошибка.".$e->getMessage();
    }
    }
}
?>