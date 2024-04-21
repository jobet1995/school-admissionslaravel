{ pkgs }: {
	deps = [
   pkgs.sqlite
   pkgs.python38Packages.mysql-connector
   pkgs.mysql2pgsql
   pkgs.mysql57
   pkgs.mysql80
		pkgs.php80
        pkgs.php80Packages.composer
	];
}