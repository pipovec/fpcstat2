<?php

namespace App\Model;
use Nette;

/**
 * Provádí operace nad databázovou tabulkou.
 */
class Stronghold
{
    use Nette\SmartObject;
    
    /** @var Nette\Database\Connection */
    protected $pgsql;

    public function __construct(Nette\Database\Context $db) {
        $this->pgsql = $db;
    }
   

    function TanksBattles(string $table, int $level, int $limit) {
        $query = "
        SELECT $table.tank_id, sum($table.battles) AS battles, avg($table.damage_dealt)::integer AS damage,encyclopedia_vehicles.name,encyclopedia_vehicles.level
        FROM $table
        LEFT JOIN encyclopedia_vehicles ON encyclopedia_vehicles.tank_id = $table.tank_id
        WHERE $table.date = ('now'::text::date - '1 day'::interval) AND level = $level
        GROUP BY $table.tank_id, encyclopedia_vehicles.name, encyclopedia_vehicles.level
        ORDER BY battles DESC
        LIMIT $limit
        ";

        return $this->pgsql->query($query);
    }

    function TanksBattles7(string $table, int $level, int $limit)   {
        $query = "
        SELECT $table.tank_id, sum($table.battles) AS battles, avg($table.damage_dealt)::integer AS damage,encyclopedia_vehicles.name,encyclopedia_vehicles.level
        FROM $table
        LEFT JOIN encyclopedia_vehicles ON encyclopedia_vehicles.tank_id = $table.tank_id
        WHERE $table.date > ('now'::text::date - '7 day'::interval) AND level = $level
        GROUP BY $table.tank_id, encyclopedia_vehicles.name, encyclopedia_vehicles.level
        ORDER BY battles DESC
        LIMIT $limit
        ";

        return $this->pgsql->query($query);
    }
}