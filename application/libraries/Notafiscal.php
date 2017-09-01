<?php

require_once '/var/www/html/nfe/bootstrap.php';


use NFePHP\NFe\MakeNFe;
use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;


class Notafiscal
{
    //Dados da NFe - infNFe
    public $cUF = '35'; //codigo numerico do estado
    public $cNF; //numero aleatório da NF
    public $natOp  = 'Venda de Produto'; //natureza da operação
    public $indPag = '2'; //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
    public $mod    = '55'; //modelo da NFe 55 ou 65 essa última NFCe
    public $serie  = '0'; //serie da NFe
    public $nNF    ; // numero da NFe
    public $dhEmi; //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
    public $tpNF     = '1';
    public $idDest   = '1'; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
    public $cMunFG   = '3550308';
    public $tpImp    = '1'; //0=Sem geração de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem;
    public $tpEmis   = '1'; //1=Emissão normal (não em contingência);
    public $tpAmb    = '1'; //1=Produção; 2=Homologação
    public $finNFe   = '1'; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
    public $indFinal = '1'; //0=Normal; 1=Consumidor final;
    public $indPres  = '1'; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
    public $procEmi  = '0'; //0=Emissão de NF-e com aplicativo do contribuinte;
    public $verProc  = '4.0.43'; //versão do aplicativo emissor
    public $versao;
    public $cDV;
    public $chave;
    public $nfe;
    public $nfeTools;
    public $produtos = array();
    public $resp;

    public function __construct()
    {



        $this->nfe      = new MakeNFe();
        $this->nfeTools = new ToolsNFe('/var/www/html/nfe/config/config.json');
        $this->cNF      = rand(50000000,10000000);
        $this->nNF    	= $this->cNF;
        $this->dhEmi    = date("Y-m-d\TH:i:sP");
        $ano            = date('y', strtotime($this->dhEmi));
        $mes            = date('m', strtotime($this->dhEmi));
        $this->chave    = $this->nfe->montaChave($this->cUF,$ano,$mes,$this->nfeTools->aConfig['cnpj'],$this->mod,$this->serie,$this->nNF, $this->tpEmis, $this->cNF);
        $this->versao   = '3.10';
        	
  		$this->resp     = $this->nfe->taginfNFe($this->chave, $this->versao);
       	$this->cDV 			= substr($this->chave, -1); 


       	$this->resp 	= $this->nfe->tagide($this->cUF, $this->cNF, $this->natOp, $this->indPag, $this->mod, $this->serie, $this->nNF, $this->dhEmi, $this->dhSaiEnt, $this->tpNF, $this->idDest, $this->cMunFG, $this->tpImp, $this->tpEmis, $this->cDV, $this->tpAmb, $this->finNFe, $this->indFinal, $this->indPres, $this->procEmi, $this->verProc, $this->dhCont, $this->xJust);

        // Dados da razão social
        $CNPJ       = $this->nfeTools->aConfig['cnpj'];
        $CPF        = ''; // Utilizado para CPF na nota
        $xNome      = $this->nfeTools->aConfig['razaosocial'];
        $xFant      = $this->nfeTools->aConfig['nomefantasia'];
        $IE         = '140890620118';
        $IEST       = $this->nfeTools->aConfig['iest'];
        $IM         = $this->nfeTools->aConfig['im'];
        $CNAE       = $this->nfeTools->aConfig['cnae'];
        $CRT        = $this->nfeTools->aConfig['regime'];
        $this->resp = $this->nfe->tagemit($CNPJ, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);





        //endereço do emitente
        $xLgr       = 'Rua Clodomiro Amazonas';
        $nro        = '1158';
        $xCpl       = 'Loja 3';
        $xBairro    = 'Itaim Bibi';
        $cMun       = '3550308';
        $xMun       = 'São Paulo';
        $UF         = 'SP';
        $CEP        = '04537002';
        $cPais      = '1058';
        $xPais      = 'Brasil';
        $fone       = '1135822084';
        $this->resp = $this->nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);




    }

    public function destinatario($dados = array())
    {



        //destinatário
        $CNPJ = $dados['cnpj'];
        $CPF  = $dados['cpf'];

        // $idEstrangeiro  = '';
        $xNome     = $dados['nome'];
        $indIEDest = '9';
        $IE        = '';
        $ISUF      = '';
        $IM        = '4128095';
        $email     = $dados['email'];
        $this->resp      = $this->nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);

        //Endereço do destinatário
        $xLgr    = $dados['endereco_rua'];
        $nro     = $dados['endereco_numero'];
        $xCpl    = '';
        $xBairro = $dados['bairro'];
        $cMun    = $dados['codigo_municipio'];
        $xMun    = $dados['municipio'];
        $UF      = $dados['uf'];
        $CEP     = $dados['cep'];
        $cPais   = $dados['codigo_pais'];
        $xPais   = $dados['pais'];
        $fone    = $dados['telefone'];

        $this->resp = $this->nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);
    }

    public function addProduto($produtos=array())
    {

        $valorTotal         = 0;
        $valorICMSTotal     = 0;
        
        foreach ($produtos as $key => $prod) {
            $precoValor     =  $prod['preco_produto']; 
            $valorTotal     =  $valorTotal + $prod['unidade_produto']*$precoValor;
        }

        $valorTotal 		=  number_format($valorTotal,2, '.','');
        $valorICMS          =  (18*$valorTotal)/100;
        $valorICMS 			=  number_format($valorICMS,2,'.','');


        foreach ($produtos as $key => $prod) {


        	$valorPorItem = number_format($prod['unidade_produto']*$prod['preco_produto'],2, '.', '');

            $nItem      = $key+1;
            $cProd      = $prod['id_produto'];
            $cEAN       = '';
            $xProd      = $prod['nome_produto'];
            $NCM        = '22030000';
            $EXTIPI     = $prod['EXTIPI'];
            $CFOP       = '5101';
            $uCom       = 'UN';
            $qCom       = number_format($prod['unidade_produto'],4,'.','');
            $vUnCom     = number_format($prod['preco_produto'],2,'.','');
            $vProd      = $valorPorItem;//$prod['unidade_produto']*$prod['preco_produto'];
            $cEANTrib   = $prod['cEANTrib'];
            $uTrib      = 'UN';
            $qTrib      = $vProd/$prod['unidade_produto'];
            $vUnTrib    = $vProd/$qTrib;
            $vFrete     = $prod['vFrete'];
            $vSeg       = $prod['vSeg'];
            $vDesc      = $prod['vDesc'];
            $vOutro     = $prod['vOutro'];
            $indTot     = 1;
            $xPed       = $key+1;
            $nItemPed   = $key+1;
            $nFCI       = $prod['nFCI'];

            // $valorICMSItem  = $vProd;
            // $valorICMSTotal = $valorICMSTotal + $valorICMSItem;

            $this->resp = $this->nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);


            //Impostos
            $vTotTrib           = $valorICMS; // 226.80 ICMS + 51.50 ICMSST + 50.40 IPI + 39.36 PIS + 81.84 CONFIS
       	    $this->resp         = $this->nfe->tagimposto($nItem, $vTotTrib);
       
            $this->resp = $this->nfe->tagICMSSN(
            $nItem,
            $orig           = 0,
            $csosn          = '102',
            $modBC          = '',
            $vBC            = $vProd,
            $pRedBC         = '',
            $pICMS          = '',
            $vICMS          = '',
            $pCredSN        = 0,
            $vCredICMSSN    = 0,
            $modBCST        = '',
            $pMVAST         = '',
            $pRedBCST       = '',
            $vBCST          = '',
            $pICMSST        = '',
            $vICMSST        = '',
            $vBCSTRet       = '',
            $vICMSSTRet     = ''
            );


        
            $this->resp         = $this->nfe->tagPIS($nItem, "99", "0.00", "0.00", "0.00", "", "");
            $this->resp         = $this->nfe->tagCOFINS($nItem, "99", "0.00", "0.00", "0.00", "", "");
            $modFrete           = '9'; //0=Por conta do emitente; 1=Por conta do destinatário/remetente; 2=Por conta de terceiros; 9=Sem Frete;
            $this->resp         = $this->nfe->tagtransp($modFrete);

           }



            //total
            $vBC        = '0.00';
            $vICMS      = '0.00';
            $vICMSDeson = '0.00';
            $vBCST      = '0.00';
            $vST        = '0.00';
            $vProd      = $valorTotal;
            $vFrete     = '0.00';
            $vSeg       = '0.00';
            $vDesc      = '0.00';
            $vII        = '0.00';
            $vIPI       = '0.00';
            $vPIS       = '0.00';
            $vCOFINS    = '0.00';
            $vOutro     = '0.00';
            $vNF        = number_format($vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI, 2, '.', '');
            $vTotTrib   = number_format($vICMS + $vST + $vII + $vIPI + $vPIS + $vCOFINS + $vIOF + $vISS, 2, '.', '');
            $this->resp = $this->nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);
            


    }

    public function salvarNotaPdf() {
		$chave = $this->chave;
		$xmlProt = "/var/www/html/nfe/producao/enviadas/aprovadas/{$this->chave}-nfe.xml";
		$xmlProt = "/var/www/html/nfe/producao/enviadas/aprovadas/".date('Ym')."/{$this->chave}-protNFe.xml";
		// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
		$pdfDanfe = "/var/www/html/public/pdf/nfe/{$this->chave}-danfe.pdf";

		$docxml = FilesFolders::readFile($xmlProt);
		$danfe = new Danfe($docxml, 'P', 'A4', $this->nfeTools->aConfig['aDocFormat']->pathLogoFile, 'I', '');
		$id = $danfe->montaDANFE();
		$salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta
		return 'http://sistema.appleplanet.com.br/public/pdf/nfe/'.$this->chave.'-danfe.pdf';
    }

    public function gerarNF()
    {
        //monta a NFe e retorna na tela
        $this->resp = $this->nfe->montaNFe();

        if ($this->resp) {
            $xmlEntrada  = $this->nfe->getXML();
            $xmlAssinada = $this->nfeTools->assina($xmlEntrada);
            $this->nfeTools->setModelo($this->mod);

            $xmlEntradaDir         = "/var/www/html/nfe/producao/entradas/{$this->chave}-nfe.xml"; // Ambiente Linux
            file_put_contents($xmlEntradaDir, $xmlEntrada);

            $xmlAssinadaEntradaDir         = "/var/www/html/nfe/producao/assinadas/{$this->chave}-nfe.xml"; // Ambiente Linux
            file_put_contents($xmlAssinadaEntradaDir, $xmlAssinada);

            if (!$this->nfeTools->validarXml($xmlAssinada) || sizeof($this->nfeTools->errors)) {
                foreach ($this->nfeTools->errors as $erro) {
                    if (is_array($erro)) {
                        return array('erro' => true, 'msg' => implode("<br>",$erro));
                    } else {
                        return array('erro' => true, 'msg' => implode("<br>",$erro));
                    }
                }
            } else {
               
                $aResposta 		 = array();
                $idLote    		 = '';
                $indSinc   		 = '0';
                $flagZip   		 = false;
                $this->retorno   = $this->nfeTools->sefazEnviaLote($xmlAssinada, $this->tpAmb, $idLote, $aResposta, $indSinc, $flagZip);
        
                sleep(5);
           		
                $this->nfeTools->sefazConsultaRecibo($aResposta[nRec],$this->tpAmb,$retornoConsulta);

                if($retornoConsulta[aProt][0][cStat] == '100') {    
                    $xmlAprovadasDir         = "/var/www/html/nfe/producao/enviadas/aprovadas/{$this->chave}-nfe.xml"; 
                    file_put_contents($xmlAprovadasDir, $xmlAssinada);


                    $protAssinada = "/var/www/html/nfe/producao/enviadas/aprovadas/{$this->chave}-nfe.xml";
                    $protTemp 	  = "/var/www/html/nfe/producao/temporarias/".date('Ym')."/".$aResposta[nRec]."-retConsReciNFe.xml";

                    $this->nfeTools->addProtocolo($protAssinada,$protTemp,true);

                    $retornoConsulta['urlPdf'] = $this->salvarNotaPdf();
                    return array('erro' => false, 'msg' => $retornoConsulta);
                } else {
                    return array('erro' => true,  'msg' => 'Não foi possivel gerar.'.print_r($retornoConsulta,true));
                }

            }
        }

    }
}

