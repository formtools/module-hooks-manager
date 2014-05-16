<?php

require_once("../../global/library.php");
ft_init_module_page();

$folder = dirname(__FILE__);
require_once("$folder/library.php");

if (isset($_POST["add_rule"]))
  list($g_success, $g_message) = hm_add_rule($_POST);
else if (isset($_GET["delete"]))
  list($g_success, $g_message) = hm_delete_rule($_GET["delete"]);

$per_page = ft_get_module_settings("num_rules_per_page");

$page = ft_load_module_field("hooks_manager", "page", "page", 1);
$rule_info   = hm_get_rules($per_page, $page);
$results     = $rule_info["results"];
$num_results = $rule_info["num_results"];

// ------------------------------------------------------------------------------------------------

$page_vars = array();
$page_vars["head_title"]  = $L["module_name"];
$page_vars["results"]     = $results;
$page_vars["num_results"] = $num_results;
$page_vars["pagination"] = ft_get_page_nav($num_results, $per_page, $page, "");
$page_vars["head_js"] =<<< EOF
var page_ns = {};
page_ns.delete_rule = function(rule_id)
{
  if (confirm("{$L["confirm_delete_rule"]}"))
    window.location = 'index.php?delete=' + rule_id;

  return false;
}
EOF;

ft_display_module_page("templates/index.tpl", $page_vars);