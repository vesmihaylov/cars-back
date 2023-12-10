<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Change User Password Request DTO
 */
class ChangeUserPasswordRequest
{
    #[Assert\NotBlank(message: 'ID на потребител не е подадено.')]
    public string $userId;

    #[Assert\NotBlank(message: 'Моля, въведете новата парола.')]
    #[Assert\Length(min: 8, minMessage: 'Моля, въведете поне 8 символа за парола.')]
    public string $newPassword;

    #[Assert\NotBlank(message: 'Моля, повторете новата парола.')]
    #[Assert\Length(min: 8, minMessage: 'Моля, въведете поне 8 символа за парола.')]
    public string $repeatNewPassword;

    #[Assert\NotBlank(message: 'Моля, въведете старата парола.')]
    public string $oldPassword;
}
