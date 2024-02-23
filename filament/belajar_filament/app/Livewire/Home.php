<?php

namespace App\Livewire;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;

class Home extends Component implements HasForms
{
    use InteractsWithForms;

    public $name = '';
    public $gender = '';
    public $birthday = '';
    public $religion = '';
    public $contact = '';
    public $profile;

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
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
                        ->options([
                            "Hindu" => "Hindu",
                            "Islam" => "Islam"
                        ]),
                    TextInput::make('contact'),
                    TextInput::make('profile')
                        ->type('file')
                        ->extraAttributes(['class' => 'rounded'])
                ])
        ]);
    }
    public function render()
    {
        return view('livewire.home');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        //process upload file
        if ($this->profile) {
            $uploadedFile = $this->profile;
            $fileName = time() . '-' . $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('public/students', $fileName);

            $data['profile'] = 'students/'.$fileName;
        }

        Student::insert($data);

        // Tambahkan Database Notification
        Notification::make()
            ->success()
            ->title('Murid ' .$this->name. ' telah mendaftar')
            ->sendToDatabase(User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get());

        session()->flash('message', 'Save Successfully');
    }

    public function delSession(): void
    {
        session()->forget('message');
        $this->name = '';
        $this->gender = '';
        $this->birthday = '';
        $this->religion = '';
        $this->contact = '';
        $this->profile = null;

    }
}
