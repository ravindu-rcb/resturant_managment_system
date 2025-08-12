<?php

use Illuminate\Support\Facades\Schedule;

// Run our command every minute
Schedule::command('orders:dispatch-scheduled')->everyMinute();

