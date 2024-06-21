<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icons = [
            'ti ti-home' => 'home', 'ti ti-settings' => 'Pengaturan', 'ti ti-building-bank' => 'Bank', 'ti ti-wallet' => 'Wallet', 'ti ti-box' => 'Box', 'ti ti-discount-check' => 'Discount Check',
            'ti ti-coin' => 'Coin', 'ti ti-currency-dollar' => 'Dollar', 'ti ti-cash' => 'Cash', 'ti ti-credit-card' => 'Credit Card', 'ti ti-credit-card-off' => 'Credit Card Off', 'ti ti-folder-filled' => 'Folder', 'ti ti-folder-open' => 'Folder Open', 'ti ti-list-details' => 'List', 'ti ti-list-check' => 'List Check', 'ti ti-books' => 'Books', 'ti ti-color-swatch' => 'Books Swatch', 'ti ti-scale' => 'Neraca', 'ti ti-scale-off' => 'Neraca Off', 'ti ti-chart-pie' => 'Chart', 'ti ti-chart-pie-2' => 'Chart 2', 'ti ti-chart-line' => 'Chart Line', 'ti ti-chart-bar' => 'Chart Bar', 'ti ti-chart-histogram' => 'Chart Histogram', 'ti ti-chart-infographic' => 'Chart Infographic', 'ti ti-server' => 'Server', 'ti ti-server-2' => 'Server 2', 'ti ti-server-bolt' => 'Server Bolt', 'ti ti-server-cog' => 'Server Config', 'ti ti-sitemap' => 'Sitemap', 'ti ti-user' => 'User', 'ti ti-user-edit' => 'User Edit', 'ti ti-stack-2' => 'Stack', 'ti ti-database' => 'Database', 'ti ti-receipt-tax' => 'Receipt Tax', 'ti ti-calendar' => 'Calendar', 'ti ti-calendar-clock' => 'Calendar Clock', 'ti ti-calendar-time' => 'Calendar Time', 'ti ti-calendar-month' => 'Calendar Month', 'ti ti-calculator' => 'Calculator', 'ti ti-switch-vertical' => 'Transaction', 'ti ti-switch-horizontal' => 'Transaction 2', 'ti ti-transfer-vertical' => 'Transfer', 'ti ti-cast' => 'Cast', 'ti ti-asset' => 'Asset', 'ti ti-receipt-refund' => 'Receipt Refund', 'ti ti-discount-2' => 'Discount 2', 'ti ti-discount-check-filled' => 'Discount Chek Fill', 'ti ti-printer' => 'Printer', 'ti ti-percentage' => 'Percent', 'ti ti-license' => 'License', 'ti ti-report' => 'Report', 'ti ti-report-analytics' => 'Report Analytics', 'ti ti-repeat' => 'Repeat', 'ti ti-database-export' => 'Database Export', 'ti ti-archive' => 'Archive', 'ti ti-device-laptop' => 'Laptop', 'ti ti-mail' => 'Mail', 'ti ti-mail-fast' => 'Mail Fast', 'ti ti-mail-up' => 'Mail Send', 'ti ti-mail-forward' => 'Mail Forward', 'ti ti-send' => 'Send', 'ti ti-inbox' => 'Inbox', 'ti ti-message' => 'Message', 'ti ti-message-2' => 'Message 2', 'ti ti-message-circle' => 'Message Circle', 'ti ti-message-report' => 'Message Report', 'ti ti-message-chatbot' => 'Message Chatbot', 'ti ti-note' => 'Note', 'ti ti-brand-whatsapp' => 'WhatsApp', 'ti ti-message-share' => 'Message Share', 'ti ti-lock' => 'Lock', 'ti ti-lock-open' => 'Lock Open'
        ];

        foreach ($icons as $key => $value) {
            DB::table('master_icons')->insert([
                'icon'=>$key,
                'name'=>$value,
                'created_at'=>now()
            ]);
        }
    }
}
