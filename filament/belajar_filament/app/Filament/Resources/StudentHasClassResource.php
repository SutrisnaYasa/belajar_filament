<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Periode;
use App\Models\Student;
use App\Models\HomeRoom;
use Filament\Forms\Form;
use App\Models\Classroom;
use Filament\Tables\Table;
use App\Models\StudentHasClass;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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

    public static function shouldRegisterNavigation(): bool
    {
        if(auth()->user()->can('classroom')){
            return true;
        }
        else{
            return false;
        }
    }

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
                        // Select::make('homerooms_id')
                        //     ->searchable()
                        //     ->options(HomeRoom::all()->pluck('classroom.name', 'id'))
                        //     ->label('Class'),
                        Select::make('classrooms_id')
                            ->searchable()
                            ->options(Classroom::all()->pluck('name', 'id'))
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
                // TextColumn::make('homeroom.classroom.name'),
                TextColumn::make('classrooms.name'),
                TextColumn::make('periode.name'),
            ])
            ->filters([
                // SelectFilter::make('homerooms_id')
                // ->options(HomeRoom:all()->pluck('classroom.name', 'id')),
                SelectFilter::make('classrooms_id')
                    ->options(Classroom::all()->pluck('name', 'id')),
                SelectFilter::make('periode_id')
                    ->options(Periode::all()->pluck('name', 'id')),
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
