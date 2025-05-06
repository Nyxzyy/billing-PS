<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TapoController extends Controller
{
    public function controlPlug(Request $request)
    {
        // Ambil aksi dari query parameter atau body request
        $action = $request->input('action'); // on or off

        if (!in_array($action, ['on', 'off'])) {
            return response()->json(['error' => 'Invalid action. Use "on" or "off"'], 400);
        }

        // Tentukan path ke script Node.js
        $scriptPath = resource_path('js/tapo_control.js');

        // Jalankan script Node.js dengan action sebagai parameter
        $process = new Process(['node', $scriptPath, $action]);
        $process->run();

        // Cek apakah proses berhasil
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Menampilkan hasil eksekusi
        return response()->json(['message' => 'Plug ' . $action . ' berhasil', 'output' => $process->getOutput()]);
    }
}
