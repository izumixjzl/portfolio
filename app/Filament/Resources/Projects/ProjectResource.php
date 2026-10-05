<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Basics')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('title')->required()->maxLength(255),
                    TextInput::make('slug')
                        ->helperText('Leave blank to generate from the title.')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Textarea::make('summary')
                        ->helperText('One or two sentences shown on project cards.')
                        ->required()
                        ->maxLength(300)
                        ->rows(2)
                        ->columnSpanFull(),
                    TextInput::make('role')->placeholder('e.g. Full-stack developer'),
                    TextInput::make('year')->placeholder('2026')->maxLength(20),
                    TagsInput::make('tech_stack')
                        ->label('Tech stack')
                        ->placeholder('Add a technology and press Enter')
                        ->columnSpanFull(),
                ]),

            Section::make('Case study')
                ->description('Markdown: the problem, what you built, architecture, and what you would improve.')
                ->columnSpanFull()
                ->schema([
                    MarkdownEditor::make('description')->hiddenLabel()->columnSpanFull(),
                ]),

            Section::make('Images')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('cover_image')
                        ->image()
                        ->disk('public')
                        ->directory('projects')
                        ->imageEditor()
                        ->maxSize(4096),
                    FileUpload::make('gallery')
                        ->label('Screenshots')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->disk('public')
                        ->directory('projects/gallery')
                        ->maxSize(4096),
                ]),

            Section::make('Links & visibility')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('repo_url')->label('GitHub / repo URL')->url(),
                    TextInput::make('live_url')->label('Live demo URL')->url(),
                    Toggle::make('is_published')->label('Published')->default(true),
                    Toggle::make('is_featured')->label('Feature on home page'),
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('cover_image')->disk('public')->label('')->square(),
                TextColumn::make('title')->searchable()->weight('bold')
                    ->description(fn (Project $record) => $record->summary),
                TextColumn::make('year')->sortable(),
                ToggleColumn::make('is_featured')->label('Featured'),
                ToggleColumn::make('is_published')->label('Published'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
