<?php

uprofiler_enable(UPROFILER_FLAGS_CPU + UPROFILER_FLAGS_MEMORY);

register_shutdown_function(function () {
    $uprofiler_data = uprofiler_disable();

    if(function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }

    include_once __DIR__ . '/../uprofiler_lib/utils/uprofiler_lib.php';
    include_once __DIR__ . '/../uprofiler_lib/utils/uprofiler_runs.php';

    $uprofilerRuns = new uprofilerRuns_Default();
    $uprofilerRuns->save_run($uprofiler_data);
});

