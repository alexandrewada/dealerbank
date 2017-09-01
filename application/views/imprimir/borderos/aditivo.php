<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>

<style type="text/css">
	.page {
		font-size: 12px;
	}
	.bordero-dados, .bordero-titulos {
		/*background-color: #ddd;*/
		margin-bottom: 2px;
	}
	.bordero-calculos .campo {
		text-align: left;
		padding-left: 8px;
		font-weight: 900;
		/*border-bottom: 1px solid #ccc;*/
		/*border-bottom-style: dashed;;*/
	}
	.bordero-calculos .valor {
		text-align: right;
		padding-left: 24px;
		/*border-bottom: 1px solid #ccc;*/
		/*border-bottom-style: dashed;*/
	}
	.bordero-calculos td {
		border: 1px solid #ccc;
		font-size: 12px;
	}
	.bordero-titulos table{
		width: 100%;
		text-transform: uppercase;
		/*margin-top: 80px;*/
	}
	.bordero-titulos table thead tr td {
		font-weight: 700;
		font-size: 11px;
		text-align: center;
	}
	.bordero-titulos table tbody tr td {
		/*font-weight: 700;*/
		font-size: 10px;
		text-align: center;
	}
	hr {
		border-style: solid;
		margin-top: 15px;
		margin-bottom: 15px;
	}
	table.informativo .campo {
		text-align: right;
		font-weight: 900;
		font-size: 12px;
		text-transform: uppercase;
	}
	table.informativo .valor {
		text-align: left;
		font-size: 12px;
		text-transform: uppercase;
	}
	.page {
		font-size: 12px;
	}
	ol li {
		margin-top: 5px;
		margin-bottom: 5px;
	}


	.assinaturas tbody tr td{
		padding-top: 15px;
		padding-bottom: 15px;
	}

</style>
<div class="book">
	<div class="page">
		<?include_once "header.php";?>
		<h3 style='text-align: center'>TERMO ADITIVO N° <?=$bordero_informativo->id_bordero;?> DO CONTRATO DE FOMENTO COMERCIAL – CONVENCIONAL Nº <?=rand(1000,10000);?></h3>
		<table class="informativo">
			<tr>
				<td class="campo">Contratante:</td>
				<td class="valor"><?=$bordero_informativo->cliente;?></td>
			</tr>
			<tr>
				<td class="campo">CNPJ:</td>
				<td class="valor"><?=mask($bordero_informativo->cnpj,'##.###.###/####-##');?></td>
			</tr>
			<tr>
				<td class="campo">Contratada:</td>
				<td class="valor">DEALER BANK FOMENTO MERCANTIL LTDA</td>
			</tr>
			<tr>
				<td class="campo">CNPJ:</td>
				<td class="valor">01.810.786/0001-75</td>
			</tr>
		</table>
		<hr>
		<h3 style='text-align: center'>
		FOMENTO COMERCIAL CONVENCIONAL – COMPRA DE CRÉDITOS – DUPLICATAS
		</h3>
		<div class="bordero-titulos">
			<table >
				<thead>
					<tr>
						<td class="campo">DOC</td>
						<td class="campo">TIPO</td>
						<td class="campo">SACADO</td>
						<td class="campo">CNPJ/CPF</td>
						<td class="campo">VENCIMENTO</td>
						<td class="campo">VALOR</td>
						
					</tr>
				</thead>
				<tbody>
					<?foreach ($bordero_titulos as $key => $v):?>
					<tr>
						<td><?=$v->id_titulo;?></td>
						<td><?=substr($v->tipo,0,3);?></td>
						<td><?=$v->sacado;?></td>
						<td>
							<?=(!empty($v->cnpj)) ? mask($v->cnpj,'##.###.###/####-##') : mask($v->cpf,'###.###.###.##');?>
						</td>
						<td><?=date('d/m/Y',strtotime($v->data_vencimento));?></td>
						<td>R$ <?=$v->valor;?></td>
						
					</tr>
					<?endforeach;?>
					
				</tbody>
			</table>
		</div>
		<hr>
		<ol>
			<li>
			Responsabilizam-se a <b>CONTRATANTE</b> e seu (s) <b>RESPONSÁVEL (eis) SOLIDÁRIO</b> (os) pela legitimidade, legalidade e veracidade do(s) título(s), acima relacionado(s) e ainda pela obrigação de recompra de quaisquer dos títulos, mesmo em caso de mera inadimplência.</li>
			<li>
				A <b>CONTRATANTE</b> obriga-se, desde já, a dar ciência ao <b>SACADO-DEVEDOR</b> da alienação do título acima
				negociado, responsabilizando-se por informá-lo que o respectivo(s) pagamento(s) deverá(ão) ser feito(s)
				diretamente à <b>CONTRATADA</b>.
			</li>
			<li>
				O presente <b>Termo Aditivo</b> é firmado em caráter irrevogável e irretratável, obrigando as partes contratantes,
				seus herdeiros e sucessores a qualquer título.
			</li>
			<li>
				A <b>CONTRATANTE</b> ratifica, neste ato, todas as condições estabelecidas nas cláusulas do Contrato de
				Fomento Comercial, firmado entre as partes.
			</li>
			<li>
				<div class='bordero-calculos'>
					<h3>Demonstrativo de Cálculo</h3>
					<table>
						<tbody>

							<tr>
								<td class="campo">Fator:</td>
								<td class="valor"><?=$bordero_calculo->fator;?>%</td>
							</tr>
							
							<tr>
								<td class="campo">Valor Total:</td>
								<td class="valor"><?=$bordero_calculo->valor_total;?></td>
							</tr>
							
							<tr>
								<td class="campo">Diferencial de Compra:</td>
								<td class="valor"><?=$bordero_calculo->diferencial_compra;?></td>
							</tr>
							
							<tr>
								<td class="campo">Ad Valorem:</td>
								
								<td class="valor"><?=$bordero_calculo->av;?></td>
							</tr>
							<tr>
								<td class="campo">Ressarc ISS:</td>
								
								<td class="valor"><?=$bordero_calculo->iss;?></td>
							</tr>
							<tr>
								<td class="campo">Ressarc IOF:</td>
								
								<td class="valor"><?=$bordero_calculo->iof_total;?></td>
							</tr>
							
							<tr>
								<td class="campo">Tarifas Cobrança:</td>
								<td class="valor"><?=$bordero_informativo->tarifas;?></td>
							</tr>
<!-- 							<tr>
								<td class="campo">Outras Despesas:</td>
								<td  class="valor"></td>
							</tr> -->

							<?if($bordero_calculo->imposto_retido >= 10):?>
								<tr>
									<td class="campo">Impostos Retidos:</td>
									<td  class="valor">
		
										<?=$bordero_calculo->imposto_retido;?>
								
									</td>
								</tr>
							<?endif;?>
							
							<?if($bordero_calculo->imposto_retido >= 10):?>
						
								<tr>
									<td class="campo" style="padding-left: 25px;">IR:</td>
									
									<td class="valor">
										<?=$bordero_calculo->ir;?>
									</td>
									
								</tr>
								
							<?endif;?>

							<?if($bordero_calculo->imposto_retido >= 10):?>
						
								<tr>
									<td class="campo" style="padding-left: 25px;">COFINS:</td>
									<td class="valor">
										<?if($bordero_calculo->imposto_retido >= 10):?>
										<?=$bordero_calculo->cofins;?>
										<?endif;?>
									</td>
								</tr>
							
							<?endif;?>

							<?if($bordero_calculo->imposto_retido >= 10):?>
						
								<tr>
									<td class="campo" style="padding-left: 25px;"">CSLL:</td>
									<td class="valor">
										<?if($bordero_calculo->imposto_retido >= 10):?>
										<?=$bordero_calculo->csll;?>
										<?endif;?>
									</td>
								</tr>
							<?endif;?>	

							<?if($bordero_calculo->imposto_retido >= 10):?>
						

							<tr>
								<td class="campo" style="padding-left: 25px;" >PIS:</td>
								<td  class="valor">
									<?if($bordero_calculo->imposto_retido >= 10):?>
									<?=$bordero_calculo->pis;?>
									<?endif;?>
								</td>
							</tr>
						
							<?endif;?>

							<?if($bordero_calculo->imposto_retido >= 10):?>
								<tr>
									<td class="campo">Ressarc Pgto Guias (Imp Retidos):</td>
									<td  class="valor"></td>
								</tr>
							<?endif;?>


							<tr>
								<td class="campo">Valor do Desembolso:</td>
								<td  class="valor">R$ <?=$bordero_calculo->valor_liquido-$bordero_informativo->tarifas;?></td>
							</tr>
						</tbody>
					</table>
					<br><br>
				</div>
			</li>
			
			<li>
				O valor líquido de <b>R$ <?=$bordero_calculo->valor_liquido-$bordero_informativo->tarifas;?></b> foi pago, neste ato, pela <b>CONTRATADA</b> à <b>CONTRATANTE</b>, através de transferência bancária para o banco <b><?=$banco->nome;?></b> Agência <b><?=$banco->agencia;?></b> Conta-<?=$banco->tipo;?> <b><?=$banco->conta;?></b> CPF/CNPJ <b><?=$banco->cpf_cnpj;?></b> favorecido <b><?=strtoupper($banco->favorecido);?></b>, fato pelo qual a <b>CONTRATANTE</b> dá à <b>CONTRATADA</b>, plena, rasa e irrevogável quitação de paga e satisfeita, sem mais nada a reclamar, seja a que título for, sem exceção.
			</li>
		</ol>
	</div>

	<div class="page">

		<b>São Paulo, <?=strftime('%d de %B de %Y', strtotime('today'));?></b>

		<br><br><br><br><br>

			<div style="width: 100%; display: inline-block; margin-top: 40px; margin-bottom: 40px;">
				<div style="width: 48%; float: left; text-align: center;">
					<div style="border-top: 1px solid black;"><b>DEALER BANK FOMENTO MERCANTIL LTDA</b><br /> Representada(o) por <b>Carlos Alberto Fagundes Steil</b></div>
				</div>
				
				<div style="width: 48%; float: right; text-align: center;">
					<div style="border-top: 1px solid black;"><b><?=$bordero_informativo->cliente;?></b><br /> Representada(o) por <b>Alexandre Wada</b></div>
				</div>
			
				<div style="width: 48%;text-align: left; float: left;margin-bottom: 40px; margin-top: 65px;">
					<div style="border-top: 1px solid black; text-align: center;">
						Fiel Depositário: <br><b>Alexandre Wada</b>
					</div>
				</div>
			</div>

			<div style="width: 100%; display: inline-block;  margin-top: 20px; margin-bottom: 20px;">
				<div style="width: 48%; float: left; text-align: center;">
					<div style="border-top: 1px solid black;">
						Responsável(eis) Solidário(s):<br>
						<b>Alexandre Riuti Wada</b>
					</div>
				</div>
				
				<div style="width: 48%; float: right; text-align: center;">
					<div style="border-top: 1px solid black;">
						Responsável(eis) Solidário(s):<br>
						<b>Alexandre Riuti Wada</b>
					</div>
				</div>
		
			</div>



			<div style="width: 100%; display: inline-block; margin-top: 20px; margin-bottom: 20px;">
				<div style="width: 48%; float: left; text-align: center;">
					<div style="border-top: 1px solid black;">
						TESTEMUNHA 1:<br>
						<b>LUCIVETE MOTA DE OLIVEIRA CPF 291.423.878-92</b>
					</div>
				</div>
				
				<div style="width: 48%; float: right; text-align: center;">
					<div style="border-top: 1px solid black;">
						TESTEMUNHA 2:<br>
						<b>LUCINEIDE FERREIRA DA MOTA CPF 013.287.835-61</b>
					</div>
				</div>
		
			</div>

	</div>
</div>