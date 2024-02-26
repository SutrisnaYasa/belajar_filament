<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\ReligionStatus;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewStudentResource\Pages;
use App\Filament\Resources\NewStudentResource\RelationManagers;



class NewStudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Mengubah nama menu di navbar
    protected static ?string $navigationLabel = 'New Student';
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
                        TextInput::make('nim')
                            ->label('NIM'),
                        TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        Select::make('gender')
                            ->options([
                                "Male" => "Male",
                                "Female" => "Female"
                            ]),
                        DatePicker::make('birthday')
                            ->label("Birthday"),
                        Select::make('religion')
                            ->options(ReligionStatus::class),
                        TextInput::make('contact'),
                        FileUpload::make('profile')
                            ->directory("students"),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Gender'),
                TextColumn::make('birthday')
                    ->label("Birthday")
                    ->toggleable(isToggledHiddenByDefault: true), // untuk hide dari tampilan tabel
                TextColumn::make('contact')
                    ->label("Contact"),
                SelectColumn::make('religion')->options(ReligionStatus::class),
                ImageColumn::make('profile')
                    ->circular()->extraImgAttributes(['img_preview'])
                    ->label("Profile"),
                TextColumn::make('status')
                    ->label("Status")
                    ->formatStateUsing(fn (string $state): string => ucwords("{$state}")),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        'accept' => 'Accept',
                        'off' => 'Off',
                        'move' => 'Move',
                        'grade' => 'Grade',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('Accept')
                        ->icon('heroicon-m-check')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            return $records->each(function ($record){
                                $id = $record->id;
                                Student::where('id', $id)->update(['status' => 'accept']);
                            });
                        }),
                    BulkAction::make('Off')
                        ->icon('heroicon-m-x-circle')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            return $records->each(function ($record){
                                $id = $record->id;
                                Student::where('id', $id)->update(['status' => 'off']);
                            });
                        }),
                    BulkAction::make('Change Status')
                        ->icon('heroicon-m-check')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('Status')
                            ->label('Status')
                            ->options(['accept' => 'Accept', 'off' => 'Off', 'move' => 'Move', 'Grade' => 'Grade',])
                            ->required(),
                        ])
                        ->action(function (Collection $records, array $data){
                            $records->each(function($record) use ($data){
                                Student::where('id', $record->id)->update(['status' => $data['Status']]);
                            });
                        }),
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
            'index' => Pages\ListNewStudents::route('/'),
            'create' => Pages\CreateNewStudent::route('/create'),
            'edit' => Pages\EditNewStudent::route('/{record}/edit'),
        ];
    }
}
