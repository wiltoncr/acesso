<?php

namespace App\Controllers;

use Core\Controller;

class AcessoController extends Controller
{
    public function index()
    {
        $Obj = new Controller('acesso');
        $Obj->index();
    }

    public function add(){
        $Obj = new Controller('acesso');
        $Obj->insert();
      }

      public function delete($field_id){
        $Obj = new Controller('acesso');
        $Obj->delete($field_id);
      }

      public function edit($field_id){
        $Obj = new Controller('acesso');
        $Obj->edit($field_id);
      }
  
      public function update(){
        $Obj = new Controller('acesso');
        $Obj->update();
      }
}
