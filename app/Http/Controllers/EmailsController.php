<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailBoleto;
use App\Models\Queue;
use Carbon\Carbon;

class EmailsController extends Controller
{
    public function checkFolder(){
        //Essa função vai verificar constantemente a pasta do ftp
        // se tiver novos arquivos vai gravar no banco e alterar o nome e caminho do arquivo para envio posterior
        $hoje = Carbon::now('America/Sao_Paulo');
      //$path = "/home/sammy/ftp/files/";
        $path = public_path('app/');

      $var = scandir($path);

        foreach($var as $i){
            if ($i <> "." && $i <> ".."){
                if( (substr($i, -4)) == ".pdf"){
                   // echo substr($i, 0, -4);
                    $arqOriginal = $i;

                    $pos = strpos($arqOriginal, ".com.br");
                    if ($pos === false) {
                        $pos = strpos($arqOriginal, ".com");
                        $pos = $pos + 5;
                    }
                    else $pos = $pos + 8;

                    $nomeCliente = substr($arqOriginal, $pos, -4);
                    $email = substr($arqOriginal, 0, ($pos-1));
                    $hoje = substr($hoje, 0, 10);
                    $arqNovo = $nomeCliente . " " . $hoje . ".pdf";
                    rename(($path.$arqOriginal), ($path."enviando/".$arqNovo));

                    $model = new Queue();
                    $model->nome = $nomeCliente;
                    $model->email = $email;
                    $model->arquivo = $arqNovo;
                    $result = $model->save();

                }
            }
        }

      //dd($var);
//      foreach($var as $i){
//        if ($i <> "." && $i <> ".."){
//          if( (substr($i, -4)) == ".pdf"){
//              echo substr($i, 0, -4);
//              Mail::to(substr($i, 0, -4))
//                ->send(new SendMailBoleto(public_path('app/'.$i)));
//              unlink((public_path('app/'.$i)));
//          }
//        }
//      }

      // die();
      // //return "eae";
      //   // Precisa importar a classe Mail:
      //   // use Illuminate\Support\Facades\Mail;
      //   Mail::to('thiago.guitar@live.com')
      //       ->send(new SendMailBoleto(public_path('app/image.jpg')));

      //       return "eae";
    }

    public function sendMailFromDatabase(){
        $da = Carbon::now();

        $mesNome = $this->getMonthName($da->month);
        //$path = "/home/sammy/ftp/files/";
        $path = public_path('app/enviando/');
        $queue = Queue::first();
        $id = $queue->id;
        Mail::to($queue->email)
                ->send(new SendMailBoleto($path.$queue->arquivo,$mesNome,$queue->nome));
        unlink($path.$queue->arquivo);
        $del = Queue::find($id)->delete();
        echo "FIM";
    }

    public function complete(){
        $this->checkFolder();
        $this->sendMailFromDatabase();
    }

    public function getMonthName($monthNumber){
        switch ($monthNumber){
            case 1 : return "Janeiro";
                break;
            case 2 : return "Fevereiro";
                break;
            case 3 : return "Março";
                break;
            case 4 : return "Abril";
                break;
            case 5 : return "Maio";
                break;
            case 6 : return "Junho";
                break;
            case 7 : return "Julho";
                break;
            case 8 : return "Agosto";
                break;
            case 9 : return "Setembro";
                break;
            case 10 : return "Outubro";
                break;
            case 11 : return "Novembro";
                break;
            case 12 : return "Dezembro";
                break;
            default: return "Erro";

        }
    }
}




