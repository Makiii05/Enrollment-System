<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Department;
use App\Models\Subject;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        $activeDepartments = Department::where('status', 'active')->count();
        $totalDepartments = Department::count();
        $activeCourses = Course::where('status', 'active')->count();
        $totalCourses = Course::count();
        $activeCurricula = Curriculum::where('status', 'active')->count();
        $totalCurricula = Curriculum::count();
        $activeSubjects = Subject::where('status', 'active')->count();
        $totalSubjects = Subject::count();

        return [
            Stat::make('Active Departments', $activeDepartments)
                ->description($totalDepartments . ' total departments')
                ->descriptionIcon($activeDepartments / max($totalDepartments, 1) >= 0.5 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down' )
                ->color($activeDepartments / max($totalDepartments, 1) >= 0.5 ? 'success' : 'danger'),
            Stat::make('Active Courses', $activeCourses)
                ->description($totalCourses . ' total courses')
                ->descriptionIcon($activeCourses / max($totalCourses, 1) >= 0.5 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down' )
                ->color($activeCourses / max($totalCourses, 1) >= 0.5 ? 'success' : 'danger'),
            Stat::make('Active Curricula', $activeCurricula)
                ->description($totalCurricula . ' total curricula')
                ->descriptionIcon($activeCurricula / max($totalCurricula, 1) >= 0.5 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down' )
                ->color($activeCurricula / max($totalCurricula, 1) >= 0.5 ? 'success' : 'danger'),
            Stat::make('Active Subjects', $activeSubjects)
                ->description($totalSubjects . ' total subjects')
                ->descriptionIcon($activeSubjects / max($totalSubjects, 1) >= 0.5 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down' )
                ->color($activeSubjects / max($totalSubjects, 1) >= 0.5 ? 'success' : 'danger'),
        ];
    }
    protected static ?int $sort = 4;
}
