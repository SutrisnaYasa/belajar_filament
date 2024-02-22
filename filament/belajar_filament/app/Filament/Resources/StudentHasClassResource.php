<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Periode;
use App\Models\Student;
use App\Models\HomeRoom;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StudentHasClass;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentHasClassResource\Pages;
use App\Filament\Resources\StudentHasClassResource\RelationManagers;

class StudentHasClassResource extends Resource
{
    protected static ?string $model = StudentHasClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Grouping menu bar
    protected static ?string $navigationGroup = 'Academic';
    // Menentukan urutan atau letak menu
    protected static ?int $navigationSort = 23;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('students_id')
                            ->searchable()
                            ->options(Student::all()->pluck('name', 'id'))
                            ->label('Student'),
                        Select::make('homerooms_id')
                            ->searchable()
                            ->options(HomeRoom::all()->pluck('classroom.name', 'id'))
                            ->label('Class'),
                        Select::make('periode_id')
                            ->searchable()
                            ->options(Periode::all()->pluck('name', 'id'))
                            ->label('Periode')
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name'),
                TextColumn::make('homeroom.classroom.name'),
                TextColumn::make('periode.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentHasClasses::route('/'),
            // 'create' => Pages\CreateStudentHasClass::route('/create'),
            'create' => Pages\FormStudentClass::route('/create'),
            'edit' => Pages\EditStudentHasClass::route('/{record}/edit'),
        ];
    }
}