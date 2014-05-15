<?php /* #?ini charset="utf-8"?


[CronjobSettings]
ExtensionDirectories[]=__projet__
Scripts[]=cron_import_ong.php
Scripts[]=cron_purge_contenu.php


[CronjobPart-cron_import_ong]
Scripts[]=cron_import_ong.php

[CronjobPart-cron_purge_contenu]
Scripts[]=cron_purge_contenu.php

#php runcronjobs.php cron_import_ong
#php runcronjobs.php cron_purge_contenu

*/ ?>