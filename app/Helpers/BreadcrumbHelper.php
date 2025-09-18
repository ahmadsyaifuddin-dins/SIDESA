<?php

namespace App\Helpers;

class BreadcrumbHelper
{
    /**
     * Generate breadcrumb untuk halaman Users
     */
    public static function users($type = 'index', $user = null)
    {
        $breadcrumbs = [
            ['label' => 'Pengguna', 'url' => route('users.index')]
        ];

        switch ($type) {
            case 'create':
                $breadcrumbs[] = ['label' => 'Tambah Pengguna', 'url' => '#'];
                break;
            
            case 'edit':
                $breadcrumbs[] = ['label' => 'Edit Pengguna', 'url' => '#'];
                break;
            
            case 'show':
                $userName = $user ? $user->name : 'Detail Pengguna';
                $breadcrumbs[] = ['label' => 'Detail', 'url' => '#'];
                $breadcrumbs[] = ['label' => $userName, 'url' => '#'];
                break;
        }

        return $breadcrumbs;
    }

    /**
     * Generate breadcrumb untuk modul lain (contoh)
     */
    public static function warga($type = 'index', $warga = null)
    {
        $breadcrumbs = [
            ['label' => 'Warga', 'url' => route('warga.index')]
        ];

        switch ($type) {
            case 'create':
                $breadcrumbs[] = ['label' => 'Tambah Warga', 'url' => '#'];
                break;
            
            case 'edit':
                $breadcrumbs[] = ['label' => 'Edit Warga', 'url' => '#'];
                break;
            
            case 'show':
                $wargaName = $warga ? $warga->name : 'Detail Warga';
                $breadcrumbs[] = ['label' => 'Detail', 'url' => '#'];
                $breadcrumbs[] = ['label' => $wargaName, 'url' => '#'];
                break;
        }

        return $breadcrumbs;
    }

    public static function activityLog($type = 'index', $activityLog = null)
    {
        $breadcrumbs = [
            ['label' => 'Log Aktivitas', 'url' => route('activity-log.index')]
        ];

        return $breadcrumbs;
    }

    /**
     * Generate breadcrumb umum
     */
    public static function generate($module, $type = 'index', $data = null)
    {
        $method = strtolower($module);
        
        if (method_exists(self::class, $method)) {
            return self::$method($type, $data);
        }

        // Fallback jika method tidak ditemukan
        return [
            ['label' => ucfirst($module), 'url' => '#']
        ];
    }
}