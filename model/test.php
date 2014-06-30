  <?php
class Test extends Model{
    public function __construct() {
        parent::__construct();
    }

    public function test(){
        echo "I am a model";
    }
    public function i(){
        return $this->info();
    }
}