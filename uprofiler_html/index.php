<?php
//  Copyright (c) 2009 Facebook
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//

//
// uprofiler: A Hierarchical Profiler for PHP
//
// uprofiler has two components:
//
//  * This module is the UI/reporting component, used
//    for viewing results of uprofiler runs from a browser.
//
//  * Data collection component: This is implemented
//    as a PHP extension (uprofiler).
//
//
//
// @author(s)  Kannan Muthukkaruppan
//             Changhao Jiang
//

// by default assume that uprofiler_html & uprofiler_lib directories
// are at the same level.
$GLOBALS['UPROFILER_LIB_ROOT'] = dirname(__FILE__) . '/../uprofiler_lib';

require_once $GLOBALS['UPROFILER_LIB_ROOT'].'/display/uprofiler.php';

// param name, its type, and default value
$params = array('run'        => array(UPROFILER_STRING_PARAM, ''),
                'wts'        => array(UPROFILER_STRING_PARAM, ''),
                'symbol'     => array(UPROFILER_STRING_PARAM, ''),
                'sort'       => array(UPROFILER_STRING_PARAM, 'wt'), // wall time
                'run1'       => array(UPROFILER_STRING_PARAM, ''),
                'run2'       => array(UPROFILER_STRING_PARAM, ''),
                'source'     => array(UPROFILER_STRING_PARAM, 'uprofiler'),
                'all'        => array(UPROFILER_UINT_PARAM, 0),
                );

// pull values of these params, and create named globals for each param
uprofiler_param_init($params);

/* reset params to be a array of variable names to values
   by the end of this page, param should only contain values that need
   to be preserved for the next page. unset all unwanted keys in $params.
 */
foreach ($params as $k => $v) {
  $params[$k] = $$k;

  // unset key from params that are using default values. So URLs aren't
  // ridiculously long.
  if ($params[$k] == $v[1]) {
    unset($params[$k]);
  }
}

echo "<html>";

echo "<head><title>uprofiler: Hierarchical Profiler Report</title>";
uprofiler_include_js_css();
echo "</head>";

echo "<body>";

if (isset($_GET['run'])) {
    echo "<div><b><a href=\"/\">Home - All Reports</a></b></div>";
}

$vbar  = ' class="vbar"';
$vwbar = ' class="vwbar"';
$vwlbar = ' class="vwlbar"';
$vbbar = ' class="vbbar"';
$vrbar = ' class="vrbar"';
$vgbar = ' class="vgbar"';

$uprofiler_runs_impl = new UprofilerRuns_Default();

displayUprofilerReport($uprofiler_runs_impl, $params, $source, $run, $wts,
                    $symbol, $sort, $run1, $run2);


echo "</body>";
echo "</html>";
