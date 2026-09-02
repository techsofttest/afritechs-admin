<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Schemas\ResetPasswordForm;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationLabel = 'Reset Password';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.reset-password';

    public ?array $data = [];

    public function form(Schema $schema): Schema
    {
        return ResetPasswordForm::configure($schema)
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = auth()->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            $this->addError(
                'data.current_password',
                'The current password is incorrect.'
            );

            return;
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->form->fill();

        Notification::make()
            ->success()
            ->title('Password updated successfully')
            ->body('Your password has been changed successfully.')
            ->send();
    }
}