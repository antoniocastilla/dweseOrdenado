<?php
$c_3d_tag_options = array(
    'c3d_title' => 'c3tdc_title',
    'c3d_noof_tags' => 'c3tdc_noof_tags',
    'c3d_width' => 'c3tdc_width',
    'c3d_height' => 'c3tdc_height',
    'c3d_bg_color' => 'c3dtc_bg_color',
    'c3d_txt_color' => 'c3dtc_txt_color',
    'c3d_font_name' => 'c3dtc_font_name',
    'c3d_max_font_size' => 'c3dtc_max_font_size',
    'c3d_min_font_size' => 'c3dtc_min_font_size'
);
if(empty(get_option('c3dtc_bg_color'))) update_option($c_3d_tag_options['c3d_bg_color'], 'ffffff');
if(empty(get_option('c3dtc_txt_color'))) update_option($c_3d_tag_options['c3d_txt_color'], '333333');
?>
<div class="wrap tag-cloud-3d-admin">
    <h2><?php _e("3D Tag Cloud Options", "cardozatagcloud");?></h2>
    <?php
    if(isset($_POST['frm_submit'])):
            update_option($c_3d_tag_options['c3d_title'], inputSanitize($_POST['frm_title']));
            update_option($c_3d_tag_options['c3d_noof_tags'], inputSanitize($_POST['frm_noof_tags']));
            update_option($c_3d_tag_options['c3d_width'], inputSanitize($_POST['frm_width']));
            update_option($c_3d_tag_options['c3d_height'], inputSanitize($_POST['frm_height']));
            update_option($c_3d_tag_options['c3d_bg_color'], inputSanitize($_POST['frm_bg_color']));
            update_option($c_3d_tag_options['c3d_txt_color'], inputSanitize($_POST['frm_txt_color']));
            update_option($c_3d_tag_options['c3d_font_name'], inputSanitize($_POST['frm_font_name']));
            update_option($c_3d_tag_options['c3d_max_font_size'], inputSanitize($_POST['frm_max_font_size']));
            update_option($c_3d_tag_options['c3d_min_font_size'], inputSanitize($_POST['frm_min_font_size']));
        ?>
        <div class="alert alert-success">
            <?php _e('Options saved.', 'cardozatagcloud' ); ?>
        </div>
    <?php endif;?>
    <?php $option_value = retrieve_options();?>
    <!-- Administration panel form -->
    <form method="post" action="">
        <div class="panel panel-success">
            <div class="panel-heading">
                <label><?php _e('General Settings','cardozatagcloud');?></label>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Widget Title','cardozatagcloud');?></label>
                        <input class="form-control" type="text" name="frm_title" size="50" value="<?php echo $option_value['title'];?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Number of tags','cardozatagcloud');?></label>
                        <input data-validation="number" class="form-control" type="text" name="frm_noof_tags" value="<?php echo $option_value['no_of_tags'];?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Width','cardozatagcloud');?> (px - <?php _e('Enter only number', 'cardozatagcloud');?>)</label>
                        <input data-validation="number" data-validation-optional="true" class="form-control" type="text" name="frm_width" value="<?php echo $option_value['width'];?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Height','cardozatagcloud');?> (px - <?php _e('Enter only number', 'cardozatagcloud');?>)</label>
                        <input data-validation="number" data-validation-optional="true" class="form-control" type="text" name="frm_height" value="<?php echo $option_value['height'];?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <label><?php _e('Color Settings (Hex value)','cardozatagcloud');?></label>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Background Color','cardozatagcloud');?> (# - <?php _e('Enter only alphanumeric', 'cardozatagcloud');?>)</label>
                        <input class="form-control" data-validation="alphanumeric" type="text" name="frm_bg_color"  value="<?php echo $option_value['bg_color'];?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Text Color','cardozatagcloud');?> (# - <?php _e('Enter only alphanumeric', 'cardozatagcloud');?>)</label>
                        <input class="form-control" data-validation="alphanumeric" type="text" name="frm_txt_color"  value="<?php echo $option_value['txt_color'];?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <label><?php _e('Font Settings','cardozatagcloud');?></label>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Select the font','cardozatagcloud');?></label>
                        <select class="form-control" name="frm_font_name">
                            <option value="Default" <?php if($option_value['font_name'] == "Default") echo "selected='selected'";?>>Default</option>
                            <option value="Arial" <?php if($option_value['font_name'] == "Arial") echo "selected='selected'";?>>Arial</option>
                            <option value="Calibri" <?php if($option_value['font_name'] == "Calibri") echo "selected='selected'";?>>Calibri</option>
                            <option value="Helvetica" <?php if($option_value['font_name'] == "Helvetica") echo "selected='selected'";?>>Helvetica</option>
                            <option value="sans-serif" <?php if($option_value['font_name'] == "Sans-serif") echo "selected='selected'";?>>Sans-serif</option>
                            <option value="Tahoma" <?php if($option_value['font_name'] == "Tahoma") echo "selected='selected'";?>>Tahoma</option>
                            <option value="Times New Roman" <?php if($option_value['font_name'] == "Times New Roman") echo "selected='selected'";?>>Times New Roman</option>
                            <option value="Verdana" <?php if($option_value['font_name'] == "Verdana") echo "selected='selected'";?>>Verdana</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Maximum font size','cardozatagcloud');?> (px - <?php _e('Enter only number', 'cardozatagcloud');?>)</label>
                        <input class="form-control" data-validation="number" type="text" name="frm_max_font_size"  value="<?php echo $option_value['max_font_size'];?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?php _e('Minimum font size','cardozatagcloud');?> (px - <?php _e('Enter only number', 'cardozatagcloud');?>)</label>
                        <input class="form-control" data-validation="number" type="text" name="frm_min_font_size"  value="<?php echo $option_value['min_font_size'];?>"/>
                    </div>
                </div>
            </div>
        </div>
        <input class="btn btn-success" type="submit" name="frm_submit" value="<?php _e('Save','cardozatagcloud');?>"/>
    </form>
</div>
<?php
function inputSanitize($string){
    $string = esc_sql($string);
    $string = strip_tags($string);
    return $string;
}
?>
