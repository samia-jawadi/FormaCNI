<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:list {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users and their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = User::query();
        
        if ($role = $this->option('role')) {
            $query->where('role', $role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        
        if ($users->isEmpty()) {
            $this->info('No users found.');
            return;
        }
        
        $tableData = [];
        foreach ($users as $user) {
            $tableData[] = [
                $user->id,
                $user->nom ?: 'N/A',
                $user->email,
                $user->role,
                $user->est_actif ? '✓' : '✗',
                $user->created_at->format('Y-m-d H:i')
            ];
        }
        
        $this->table(
            ['ID', 'Name', 'Email', 'Role', 'Active', 'Created'],
            $tableData
        );
        
        $this->info("Total users: " . $users->count());
        
        // Show role counts
        $roleCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
            
        if ($roleCounts) {
            $this->newLine();
            $this->info('Role distribution:');
            foreach ($roleCounts as $role => $count) {
                $this->line("  {$role}: {$count}");
            }
        }
        
        return 0;
    }
}
