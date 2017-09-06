<?php
/**
 * Created by PhpStorm.
 * User: Leyany
 * Date: 06-Sep-17
 * Time: 4:27 PM
 */

class Thrown {

    private $thrown = array();
    private $score = 0;

    function __construct(){
        $this->thrown = array();
        for($i=0; $i<5; $i++){
            $this->thrown[] = rand(1, 6);
        }
        $this->score = $this->calculateScore($this->thrown);
    }

    public function getThrown(){
        return $this->thrown;
    }

    public function getScore(){
        return $this->score;
    }

    public function calculateScore($throw){
        $aux = array_count_values($throw);
        foreach($aux as $key => $value){
            if($value >= 3){
                if($key === 1){
                    $this->score += 1000;
                    $this->score += ($value-3)*100;
                }
                elseif($key === 5){
                    $this->score += 500;
                    $this->score += ($value-3)*50;
                }
                else
                    $this->score += ($key*100);
            }
            else{
                if($key === 1)
                    $this->score += (100*$value);
                elseif($key === 5)
                    $this->score += (50*$value);
            }
        }
        return $this->score;
    }
}

class Game {

    private $thrownArray;

    function __construct($throwCount){
        for($i=0; $i<$throwCount; $i++){
            $this->thrownArray[] = new Thrown();
        }
    }

    public function getResult(){
        $result = '<table id="throws" class="table table-striped table-bordered table-responsive table-hover">
                        <thead>
                            <tr class="tr-head">
                                <th>Throw</th><th>Score</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($this->thrownArray as $thrown){
            $result .= '<tr><td>';
            $result .= implode(' ', $thrown->getThrown());
            $result .= '</td><td>';
            $result .= $thrown->getScore();
            $result .= '</td></tr>';
        }
        $result .= '</tbody></table>';
        return $result;
    }

    public function show(){
        $page = '<!DOCTYPE html>
                <html>
                    <head>
                    <meta charset="UTF-8" content="width=device-width, initial-scale=1"/>
                    <script type="text/javascript" src="js/jquery.min.js"></script>
                    <script type="text/javascript" src="js/bootstrap.min.js"></script>
                    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
                    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
                    <link rel="stylesheet" type="text/css" href="css/template.css" />
                </head>
                    <body>
                        <nav class="navbar" id="test" style="background-color: #337AB7">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <a style="color: #f5f5f5" class="navbar-brand" href="#">Dice Game Results</a>
                                </div>
                            </div>
                        </nav>
                        <div class="container text-center">
                            <div class="row content">
                                <div class="col-sm-12 text-left">
                                    <h4><div class="form-component">Dice game results<hr></div></h4>';
        $page .= $this->getResult();
        $page .= '                  <div class="col-sm-6">
                                        <div class="form-component">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <footer class="container-fluid text-center" style="background-color: #337AB7">
                    <strong><p style="color: #f5f5f5">Leyany Yera Moya. © 2017<br>Todos los derechos reservados</p></strong>
                </footer>
                    </body>
                </html>';
        echo $page;
    }
}

$throw_count = $_REQUEST['throw'];
$dicesGame = new Game($throw_count);
$dicesGame->show();



