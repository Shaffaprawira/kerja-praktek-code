<?php
if(isset($ogfb)) :
    foreach($ogfb as $key => $val) :
        if(!is_array($val)) :
?>
        <meta property="<?php echo $key; ?>" content="<?php echo $val; ?>" /><?php echo "\n"; ?>
<?php
        else :
            $og_buffer = '<meta ';
            foreach($val as $idx => $pin) :
                $og_buffer .= $idx.'="'.$pin.'" ';
            endforeach;
            $og_buffer .= '/>';
            echo "\n        {$og_buffer}";
        endif;
    endforeach;
endif;
?>
<?php
if(isset($ogtw)) :
    foreach($ogtw as $key => $val) :
        if(!is_array($val)) :
?>
        <meta name="<?php echo $key; ?>" content="<?php echo $val; ?>" /><?php echo "\n"; ?>
<?php
        else :
            $og_buffer = '<meta ';
            foreach($val as $idx => $pin) :
                $og_buffer .= $idx.'="'.$pin.'" ';
            endforeach;
            $og_buffer .= '/>';
            echo "\n        {$og_buffer}";
        endif;
    endforeach;
endif;
?>
