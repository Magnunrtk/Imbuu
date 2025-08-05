<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PowergamersController extends Controller
{
    public function index()
    {
        $host    = env('DB_HOST', 'localhost');
        $db      = env('DB_DATABASE', 'nome_do_banco');
        $user    = env('DB_USERNAME', 'usuario');
        $pass    = env('DB_PASSWORD', 'senha');
        $charset = env('DB_CHARSET', 'utf8mb4');

        $conn = new \mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->set_charset($charset);

        $sql = "SELECT 
                    pg.account_id, 
                    p.name, 
                    p.vocation, 
                    pg.level, 
                    pg.experience, 
                    pg.data 
                FROM powergamers AS pg 
                JOIN players AS p ON pg.account_id = p.id 
                WHERE pg.experience > 0 
                  AND pg.account_id IN (
                      SELECT account_id 
                      FROM powergamers 
                      GROUP BY account_id 
                      HAVING COUNT(DISTINCT experience) > 1
                  ) 
                ORDER BY pg.data DESC";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query error: " . $conn->error);
        }

        $players = [];
        while ($row = $result->fetch_assoc()) {
            $players[] = $row;
        }

        $conn->close();

        return view('community.powergamers.index', compact('players'));
    }
}
