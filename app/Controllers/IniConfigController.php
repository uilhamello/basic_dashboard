<?php

class IniConfigController extends Controller
{

    private $user;

    public function index()
    {
        if(empty($_POST['user'])
            || empty($_POST['password'])
            || empty($_POST['host'])
            || empty($_POST['db'])
        ){
            view('iniconfig.html');
            return false;
        }else{

            $fact = new FactoryDatabase('no_auto_connect');
            $_CONFIG_DB["DRIVER"]=$_POST['driver'];
            $_CONFIG_DB["HOST"]=$_POST['host'];
            $_CONFIG_DB["DBNAME"]=$_POST['db'];
            $_CONFIG_DB["USER"]=$_POST['user'];
            $_CONFIG_DB["PASSWORD"]=$_POST['password'];

            $fact->testConnect($_CONFIG_DB);

            if($fact->getConnect()){
                $arrayIni = array(
                    'local' => array(
                        'host' => $_CONFIG_DB["HOST"],
                        'username' => $_CONFIG_DB["USER"],
                        'password' => $_CONFIG_DB["PASSWORD"],
                        'db_name' => $_CONFIG_DB["DBNAME"],
                    ));
                try{
                    if(!$this->write_ini_file($arrayIni, SYS_ROOT.'config/config.ini', true)) {
                        view('iniconfig.html');
                        return ['message'=>'Sem permissão para criar arquivo config/config.ini. <br>Libera a permissão de escrita ao diretório \'config/\' (alterando a permissao \'chmod\' ou o dono \'chown\')', 'alert-class' => 'alert-danger'];
                    }

                    if($this->create_userAction($fact)){
                        redirect_route('login');
                    }
                    else{
                        view('iniconfig.html');
                        return ['message'=>'Erro ao tentar gerar a tabela User. Tente executar: <br>'.$this->create_user(), 'alert-class' => 'alert-danger'];
                    }
                }
                catch (Exception $e){
                    view('iniconfig.html');
                    return ['message'=>'Erro na criação do config.ini. Tente novamente ou crie-o com base em config.ini.example', 'alert-class' => 'alert-danger'];
                }

            }else{
                view('iniconfig.html');
                return ['message'=>'não rolou a conexão :/ <br/> Tente novamente.', 'alert-class' => 'alert-danger'];;
            }
        }
    }

    public function write_ini_file($assoc_arr, $path, $has_sections=FALSE) {
        $content = "";
        if ($has_sections) {
            foreach ($assoc_arr as $key=>$elem) {
                $content .= "[".$key."]\n";
                foreach ($elem as $key2=>$elem2) {
                    if(is_array($elem2))
                    {
                        for($i=0;$i<count($elem2);$i++)
                        {
                            $content .= $key2."[] = \"".$elem2[$i]."\"\n";
                        }
                    }
                    else if($elem2=="") $content .= $key2." = \n";
                    else $content .= $key2." = \"".$elem2."\"\n";
                }
            }
        }
        else {
            foreach ($assoc_arr as $key=>$elem) {
                if(is_array($elem))
                {
                    for($i=0;$i<count($elem);$i++)
                    {
                        $content .= $key."[] = \"".$elem[$i]."\"\n";
                    }
                }
                else if($elem=="") $content .= $key." = \n";
                else $content .= $key." = \"".$elem."\"\n";
            }
        }

        if (!$handle = @fopen($path, 'w')) {
            return false;
        }

        $success = fwrite($handle, $content);
        fclose($handle);

        return $success;
    }

    public function create_userAction($conn)
    {
        $exit_table = $this->check_if_table_exist($conn, 'users');
        if(empty($exit_table)){
            $conn->setQueries($this->create_user());
            $conn->prepareQuery();
            return $conn->stmtExecute();
        }
        return true;
    }

    public function check_if_table_exist($conn, $table)
    {
        "SHOW TABLES LIKE '".$table."'";
        $conn->setQueries("SHOW TABLES LIKE '".$table."'");
        $conn->prepareQuery();
        return $conn->resultset();
    }

    public function create_user()
    {
        return "CREATE TABLE users (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(150) NOT NULL,
                    `username` VARCHAR(100) NOT NULL,
                    `password` VARCHAR(100) NOT NULL,
                    `created_at` DATETIME NULL,
                    `updated_at` DATETIME NULL,
                    `deleted_at` DATETIME NULL,
                    PRIMARY KEY (`id`));";
    }
}