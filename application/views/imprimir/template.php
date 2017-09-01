<!DOCTYPE >
<html>
	<head>
		<style>
			    body {
			        margin: 0;
			        padding: 0;
			        background-color: #FAFAFA;
			        font: 12pt "Tahoma";
			    }
			    * {
			        box-sizing: border-box;
			        -moz-box-sizing: border-box;
			    }
			    .page {
			        width: 21cm;
			        min-height: 29.7cm;
			        padding: 1cm;
			        margin: 1cm auto;
			        border: 1px #D3D3D3 solid;
			        border-radius: 5px;
			        background: white;
			        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			    }
			    .subpage {
			        padding: 1cm;
			        border: 5px red solid;
			        height: 256mm;
			        outline: 2cm #FFEAEA solid;
			    }

			    .titulo h3 {
			    	text-align: center;
			    	text-transform: uppercase;
			    	font-family: Verdana;
			    }

			    .titulo {
			    	margin-bottom: 50px;
			    }

			    .logo {
			    	border-bottom: 1px solid #ccc;
			    	margin-bottom: 4
			    }
			    
			    @page {
			        size: A4;
			        margin: 0;
			    }
			    @media print {
			        .page {
			            margin: 0;
			            border: initial;
			            border-radius: initial;
			            width: initial;
			            min-height: initial;
			            box-shadow: initial;
			            background: initial;
			            page-break-after: always;
			        }
			    }
		</style>
	</head>
	
	<body>
		<?=$contents;?>
	</body>
</html>
<script type="text/javascript">
	window.print();
</script>