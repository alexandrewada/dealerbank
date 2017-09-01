
<style type="text/css">
	.campo {
		font-weight: 700;
		font-family: Verdana;
		text-align: right;
		font-size: 12px;
		text-transform: uppercase;
		/*background-color: lightgrey;*/
		padding: 3px;
		padding-right: 5px;
	}

	.valor {
		font-size: 12px;
		text-transform: uppercase;
		padding-left: 5px;
	}

	.bordero-dados, .bordero-titulos {
		/*background-color: #ddd;*/
		margin-bottom: 2px;
	}

	.tabela-informativo {
		width: 100%;
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

	.titulo {
		text-decoration: underline;
	}

	

	.linha {
		border-bottom: 1px solid #ddd;
	}

	.negativo {
		color: red;
	}

	.positivo {
		color: green;
		text-align: right;
	}

	.bordero-calculos .campo {
		text-align: left;
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
	}


</style>



<div class="book">
    <div class="page">
    	<?include_once "header.php";?>

		<div class='titulo'>
			<h3>Demonstrativo de Cálculo</h3>
		</div>

		<!-- <h3>Borderô Informativo.</h3> -->
		<div class='bordero-dados'>
			<table class='tabela-informativo'>
				<tr>
					<td class="campo">Borderô:</td>
					<td class="valor"><?=$bordero_informativo->id_bordero;?></td>

					<td class="campo">Data:</td>
					<td class="valor"><?=date('d/m/Y H:i:s',strtotime($bordero_informativo->data_operacao));?></td>

					<td class="campo">Cliente:</td>
					<td class="valor"><?=$bordero_informativo->cliente;?></td>

				</tr>
<!-- 				<tr>
					<td class="campo">N° de títulos:</td>
					<td class="valor"><?=$bordero_informativo->titulos;?></td>

					<td class="campo">CNPJ:</td>
					<td class="valor"><?=$bordero_informativo->cnpj;?></td>

					<td class="campo">Operador:</td>
					<td class="valor"><?=$bordero_informativo->operador;?></td>
				</tr>
 -->
			</table>
		</div>
		
		<br><br>

		<!-- <h3>Borderô Títulos.</h3> -->
		<div class="bordero-titulos">
			<table >
				<thead>
					<tr>
						<td class="campo">DOC</td>
						<td class="campo">TIPO</td>
						<td class="campo">VENCIMENTO</td>
						<td class="campo">PRAZO</td>
						<td class="campo">FLOAT</td>
						<td class="campo">VALOR</td>
						<td class="campo">SACADO</td>
						<td class="campo">CNPJ/CPF</td>
			
					</tr>
				</thead>

				<tbody>
			 		<?foreach ($bordero_titulos as $key => $v):?>
				 		<tr>
							<td><?=$v->numero;?></td>
							<td><?=substr($v->tipo,0,3);?></td>
							<td><?=date('d/m/Y',strtotime($v->data_vencimento));?></td>
							<td><?=$v->prazo;?></td>
							<td><?=$v->float;?></td>
							<td>R$ <?=$v->valor;?></td>
							<td><?=$v->sacado;?></td>
							<td>
								<?=(!empty($v->cnpj)) ? $v->cnpj : $v->cpf;?>
							</td>
						</tr>
					<?endforeach;?>
					
				</tbody>
			</table>
		</div>

		<br><br>

		<!-- <h3>Borderô Calculos</h3> -->

		<div class='bordero-calculos'>
		<table>
			<tbody>
				<tr>
					<td class="campo">Quant. títulos:</td>
					<td class="valor"><?=$bordero_informativo->titulos;?></td>
				</tr>
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
				
					<td class="valor"><?=number_format($bordero_calculo->iof_total,2);?></td>
				</tr>
				
<!-- 				<tr>
					<td class="campo">Ressarc IOF média:</td>
				
					<td class="valor"><?=$bordero_calculo->iof_total_media;?></td>
				</tr>
 -->
	
				<tr>
					<td class="campo">Tarifas Cobrança:</td>
					<td class="valor"><?=$bordero_informativo->tarifas;?></td>
				</tr>

				<tr>
					<td class="campo">Outras Despesas:</td>
					<td class="valor"><?=$bordero_informativo->despesas;?></td>
				</tr>


				<tr>
					<td class="campo" style="padding-left: 25px;">IRRF:</td>
						
					<td class="valor">
						<?if($bordero_calculo->imposto_retido >= 10):?>	
							<?=$bordero_calculo->irrf;?>
						<?endif;?>
					</td>
				
				</tr>


				<tr>
					<td class="campo" style="padding-left: 25px;">COFINS:</td>
					<td class="valor">
						<?if($bordero_calculo->imposto_retido >= 10):?>	
							<?=$bordero_calculo->cofins;?>
						<?endif;?>

					</td>
				</tr>

				<tr>
					<td class="campo" style="padding-left: 25px;"">CSLL:</td>
					<td class="valor">
						<?if($bordero_calculo->imposto_retido >= 10):?>	
							<?=$bordero_calculo->csll;?>
						<?endif;?>

					</td>
				</tr>

				<tr>
					<td class="campo" style="padding-left: 25px;" >PIS:</td>
					<td  class="valor">
						<?if($bordero_calculo->imposto_retido >= 10):?>	
							<?=$bordero_calculo->pis;?>
						<?endif;?>

					</td>
				</tr>


				<tr>
					<td class="campo">Ressarc Pgto Guias (Imp Retidos):</td>
					<td  class="valor">
						<?if($bordero_calculo->imposto_retido >= 10):?>	
							<?=$bordero_calculo->imposto_retido;?>
						<?endif;?>
					</td>
				</tr>

				<tr>
					<td class="campo">Valor do Desembolso:</td>
					<td  class="valor">
						<?=number_format($bordero_calculo->valor_liquido,2);?>
					</td>
				</tr>
		
			</tbody>
		</table>
	</div>
    </div>
</div>

