# Copilot Instructions - Enrollment System

## Architecture Overview

This is a **Laravel 12 + Filament 4 admin panel** for academic enrollment management. The system uses a single "Registrar" panel for all features (single-panel architecture), auto-discovered resources, and custom Tailwind theming.

### Key Components
- **Filament Resources**: Auto-discovered in `app/Filament/Resources/` — define CRUD UI, search behavior, and relationships
- **Eloquent Models**: `app/Models/` — define database schema, relationships (belongsTo/hasMany), and fillable attributes
- **Theme System**: Custom CSS at `resources/css/filament/registrar/theme.css` uses `@theme` blocks and CSS layer directives
- **Build Pipeline**: Vite + @tailwindcss/vite for compiling custom colors and @apply directives

### Data Model
Six interconnected entities:
- **User** ← authentication only
- **Department** ← Course (1:Many)
- **Course** ← Curriculum (1:Many)
- **Subject** ← Prospectus (1:Many)
- **Curriculum** (curriculum_subject join)
- **Prospectus** (prospectus_subject join)

## Filament Resource Patterns

### Form Construction (`form()` method)
- Uses `Schema` builder with `->components([...])` fluent syntax
- **Select fields with relationships**: Use `->options()` with dynamic mapping for related data
  ```php
  Select::make('department_id')
      ->label('Department')
      ->options(
          Department::all()->pluck('id')->mapWithKeys(function ($id) {
              $dept = Department::find($id);
              return [$id => "{$dept->code} - {$dept->description}"];
          })
      )
      ->native(false)
      ->required()
  ```
- Wrap related form sections in `Section::make('label')->schema([...])` for organization
- Import form components explicitly: `TextInput`, `Textarea`, `Select`, `Section`

### Table Construction (`table()` method)
- Define searchable columns with `->searchable()` to enable full-text search in lists
- Use `->sortable()` for database ordering, `->toggleable()` for column visibility
- Show relationships using dot notation: `TextColumn::make('department.description')`
- Disable default toggleable columns with `->toggleable(isToggledHiddenByDefault: true)`

### Critical Configuration
- Set `protected static ?string $recordTitleAttribute = 'code'` — used in dropdown displays
- All resources auto-discovered; just create new class in `app/Filament/Resources/`
- Icons use `Heroicon` enum (e.g., `Heroicon::OutlinedAcademicCap`)

## Theming & Styling

### Tailwind Custom Colors
Colors defined in `@theme` block in CSS (NOT in config):
```css
@theme {
    --color-main-primary: #042042;
    --color-main-secondary: #eaea52;
    --color-main-black: #343434;
    --color-main-white: #ffffff;
    --color-main-light: #f6f7fb;
    --color-main-accent: #4ea1d3;
}
```

Use with `@apply` in component classes:
```css
.fi-sidebar {
    @apply bg-main-primary rounded-2xl shadow-lg m-3;
}
```

### Filament CSS Classes
- `.fi-sidebar` — left navigation panel
- `.fi-sidebar-item` — individual nav buttons
- `.fi-sidebar-item-label` — text label within nav
- `.fi-sidebar-item.fi-active` — currently active route
- `.fi-topbar` — top navigation bar
- Prefix with `.fi-` for most Filament components

### Build Notes
- Run `npm run dev` for hot reload during development
- Run `npm run build` for production
- CSS linter warnings about `@apply` are harmless; Tailwind CLI handles them correctly

## Development Workflow

### Starting the dev server
```bash
composer install
npm install
php artisan migrate
npm run dev  # In separate terminal
php artisan serve  # In another terminal
```

### Adding a New Resource (CRUD module)
1. Create model: `php artisan make:model YourModel`
2. Create migration: `php artisan make:migration create_your_models_table`
3. Create resource: `php artisan make:filament-resource YourResource`
4. Define form/table in resource class
5. Model auto-discovered; accessible at `/registrar/your-resources`

### Creating Widgets (Dashboard)
- Located in `app/Filament/Widgets/`
- Auto-discovered and registered in `RegistrarPanelProvider->widgets([])`
- Examples: `EnrolleesChart.php`, `StatsOverview.php` (already exist)

## Important Conventions

### Select Field Searching
When a Select binds to a foreign key, users must search using the **displayed** value, not the ID:
```php
// ❌ Won't work: Department ID not directly searchable
Select::make('department_id')->options([...])

// ✅ Better: Use relationship() with searchable fields
Select::make('department_id')
    ->relationship('department', 'id')
    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->code} - {$record->description}")
    ->searchable(['code', 'description'])
```

### Model Relationships
- Always define in model: `public function department() { return $this->belongsTo(Department::class); }`
- Use in tables: `TextColumn::make('department.description')->searchable()`
- Filament respects Eloquent relationships automatically

### Status Fields
Use consistent options:
```php
Select::make('status')
    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
    ->native(false)
    ->required()
```

## Debugging Tips

1. **CSS not applying**: Run `npm run build` (Tailwind compilation required)
2. **Select options empty**: Check `recordTitleAttribute` in resource; might need to override with `getOptionLabelUsing()`
3. **Search not working**: Ensure columns have `->searchable()` and relationships defined in model
4. **Widgets missing**: Check `->discoverWidgets()` in `RegistrarPanelProvider` and ensure widget class extends `Widget`

## File Organization
```
app/Filament/
  ├── Resources/          # CRUD resources (auto-discovered)
  │   ├── Courses/
  │   ├── Departments/
  │   └── ...
  └── Widgets/            # Dashboard widgets (auto-discovered)

app/Models/               # Eloquent models and relationships

resources/css/            # Stylesheets
  └── filament/registrar/
      └── theme.css       # Custom Filament theme
```

## External References
- Filament Docs: https://filamentphp.com/docs
- Laravel Eloquent: https://laravel.com/docs/eloquent
- Tailwind CSS: https://tailwindcss.com/docs
