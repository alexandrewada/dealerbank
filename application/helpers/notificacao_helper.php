<?php

    function Notificacao($titulo='',$texto='',$icon='error') {
        echo "<script>
        $.toast({
            text: '$texto',
            heading: '$titulo', 
            icon: '$icon', 
            showHideTransition: 'plain', 
            allowToastClose: true, 
            hideAfter: 10000, 
            stack: 8, 
            position: 'top-center',            
            textAlign: 'left',
            loader: true
        });
        </script>";
    }
?>