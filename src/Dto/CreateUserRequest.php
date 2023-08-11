<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;

/**
 * New User Registration Request DTO
 */
class CreateUserRequest
{
    #[Assert\NotBlank(message: 'Моля, въведете вашето име.')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Минималният брой символи на името е 3.',
        maxMessage: 'Позволеният брой символи на името е 100.'
    )]
    #[Assert\Type('string')]
    public string $name;

    #[Assert\NotBlank(message: 'Моля, въведете вашата електронна поща.')]
    #[Assert\Length(max: 150, maxMessage: 'Позволеният брой символи за пощата е 150.')]
    #[Assert\Email(message: 'Невалидна електронна поща.', mode: Email::VALIDATION_MODE_HTML5)]
    public string $email;

    #[Assert\NotBlank(message: 'Моля, въведете парола.')]
    #[Assert\Length(min: 8, minMessage: 'Моля, въведете поне 8 символа за парола.')]
    public string $password;

    #[Assert\NotBlank(message: 'Моля, въведете тип на акаунта.')]
    #[Assert\Type('string')]
    public string $type;

    #[Assert\NotBlank(message: 'Моля, въведете телефонен номер.')]
    #[Assert\Regex(
        '/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/',
        message: 'Телефонният номер не е валиден.'
    )]
    #[Assert\Type(
        type: 'numeric',
        message: 'Телефонният номер не е валиден.',
    )]
    public string $phoneNumber;
}
