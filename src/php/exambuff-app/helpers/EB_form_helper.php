<?php
/*
 * All fields have $name, $label [,...specific tags: options, checked etc], $tags
 * 
 * $tags is an array of optional tags, such as class, value, id etc.
 * 
 * Class is applied to the span wrapper and input
 */
function eb_input_text($name,$label='',$tags=false) {
	if($tags) extract($tags);
	$forCIForm = $tags;
	$forCIForm['name'] = $name;
	unset($forCIForm['sublabel']);

	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div>';
	echo form_input($forCIForm);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
function eb_input_password($name,$label='',$tags=false) {
	if($tags) extract($tags);
	$forCIForm = $tags;
	$forCIForm['name'] = $name;
	unset($forCIForm['sublabel']);

	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div>';
	echo form_password($forCIForm);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
function eb_input_textarea($name,$label='',$tags=false) {
	if($tags) extract($tags);
	$forCIForm = $tags;
	$forCIForm['name'] = $name;
	unset($forCIForm['sublabel']);

	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div class="textarea">';
	echo form_textarea($forCIForm);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
function eb_submit($name='submit',$label=null,$tags=false) {
	if($tags) extract($tags);
	$forCIForm = $tags;
	$forCIForm['name'] = $name;
	if(!@$value) $forCIForm['value'] = 'Submit';
	unset($forCIForm['sublabel']);
	echo '<span class="field '.@$class.'">';
	echo form_label($label);
	echo '<div class="submit">';
	echo form_submit($forCIForm);
	echo '</div>';
	echo '</span>';
}
function eb_checkbox($name,$label='',$value,$checked=FALSE,$tags=false) {
	if($tags) extract($tags);
	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div class="checkboxes">';
	echo form_checkbox($name,$value,$checked);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
function eb_radio($name,$label='',$value,$checked=FALSE,$tags=false) {
	if($tags) extract($tags);

	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div class="radio">';
	echo form_radio($name,$value,$checked);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
/*
 * Generates a select. Pass options in 'value'=>'text to show user' format
 */
function eb_select($name,$label='',$options,$tags=false) {
	if($tags) extract($tags);
	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div class="select">';
	if(@$id) $id = 'id="'.$id.'"';
	echo form_dropdown($name,$options,@$value);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
function eb_date($name,$label='',$tags=false) {
	if($tags) extract($tags);
	if(@!$MM) {
		$MM = date('m',time());
	}
	if(@!$YYYY) {
		$YYYY = date('Y',time());
	}
	echo '<span class="field '.@$class.'">';
	if(@$label) echo form_label($label.':');
	echo '<div class="select">';
	echo form_dropdown($name.'MM',array('01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'),
	$MM);
	echo form_dropdown($name.'YYYY',array(2008=>2008,2009=>2009,2010=>2010,2011=>2011,2012=>2012,2013=>2013),$YYYY);
	if(@$sublabel)  echo '<div class="sublabel">'.@$sublabel.'</div>';
	echo '</div>';
	echo '</span>';
}
function eb_hidden($name,$value) {
	echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
}