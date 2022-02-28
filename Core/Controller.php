<?php
declare(strict_types = 1);

namespace Core;

class Controller
{
    public $table = null;
    private $model = '';

    public function __construct($table ='clientes'){
      $this->table = $table;
      $this->model = '\\App\\Models\\'.ucfirst($this->table) . 'Model';
    }

    public function index()
    {
        $Obj = new $this->model($this->table);

        if(!empty($_GET['search'])){
            $todos = $Obj->filterRegs($_GET['search']);
        }else {
            $todos = $Obj->todosRegs(); // Todos os registros e seus dados
        }
        $obj2 = new \App\Models\ClientesModel("clientes");
        $soma = (empty($todos))? 0 : count($todos);// Total de registros, a soma
        // Carregar a view. Com as views nós podemoms mostrar $todos e a soma facilmente
        require_once APP . 'Views/_includes/header.phtml';
        require_once APP . 'Views/_includes/menu.phtml';                
        require_once APP . 'Views/'.$this->table.'/index.phtml';
        require_once APP . 'Views/_includes/footer.phtml';
    }

    public function insert()
    {
        if (isset($_POST['submit_add_' . $this->table])) {
            $obj = new $this->model($this->table);
            foreach($obj->getRequire() as  $value) {
                $result[$value] = $_POST[$value];
            }
            $obj->add($result);
	        header('location: ' . URL . $this->table.'/index');	
        }
        $obj = (new \App\Models\ClientesModel("clientes"))->listRegs("id, nome")->fetchAll();
        // Carregar views.
        require_once APP . 'Views/_includes/header.phtml';
        require_once APP . 'Views/_includes/menu.phtml';                                
        require_once APP . 'Views/'.$this->table.'/add.phtml';
        require_once APP . 'Views/_includes/footer.phtml';
    }

    public function add()
    {
        $Obj = new Model($this->table);
        $fld = $Obj->fields();
        $fld0 = $fld[0];
        $fld1 = $fld[1];
        $tab =  substr($this->table,0,-1);// Remover s final do nome da tabela
        if (isset($_POST['submit_add_'.$tab])) {
          $Obj = new $this->model($this->table);
          $Obj->add($_POST[$fld0], $_POST[$fld1]);
	        header('location: ' . URL . $this->table.'/index');	
        }

        // Carregar views.
        require_once APP . 'Views/_includes/header.phtml';
        require_once APP . 'Views/_includes/menu.phtml';                                
        require_once APP . 'Views/'.$this->table.'/add.phtml';
        require_once APP . 'Views/_includes/footer.phtml';
    }

    public function edit($field_id)
    {
        if (isset($field_id)) {
            $Obj = new $this->model($this->table);//AcessoModel($this->table);
            $um = $Obj->umReg($field_id);
            if ($um === false) {
                $page = new \Core\ErrorController();
                $page->index("teste", "teste");
            } else {
                $obj = (new \App\Models\ClientesModel("clientes"))->listRegs("id, nome")->fetchAll();
                require_once APP . 'Views/_includes/header.phtml';
				        require_once APP . 'Views/_includes/menu.phtml';                        
                require_once APP . 'Views/'.$this->table.'/edit.phtml';
                require_once APP . 'Views/_includes/footer.phtml';
            }
        } else {
            header('location: ' . URL . $this->table.'/index');
        }
    }

    public function update()
    {
        $tab = ($this->table == 'clientes')? substr($this->table,0,-1): $this->table;// Remover es final do nome da tabela
        if (isset($_POST['submit_update_'.$tab]) && isset($_POST["field_id"])) {
            $Obj = new $this->model($this->table);
            foreach($Obj->getRequire() as  $value) {
                $result[$value] = $_POST[$value];
            }
            $result["field_id"] = $_POST["field_id"];
            $Obj->update($result);
        }

        header('location: ' . URL . $this->table.'/index');
    }

    public function delete($field_id)
    {
        if (isset($field_id)) {
            $Obj = new Model($this->table);
            $Obj->delete($field_id);
        }

        header('location: ' . URL . $this->table.'/index');
    }
}
