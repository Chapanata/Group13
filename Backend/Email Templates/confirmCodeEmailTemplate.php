<?php
include 'emailTemplate.php';

function getEmail($confirmCode, $email, $name)
{
    $mail =
'
<p>Hi '.$name.',</p>
<p>Thank you for registering with our platform. Here\'s your confirmation code, <b>' . $confirmCode . '</b></p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="https://jorde.dev/ContactDeluxe/Endpoints/confirmCode.php?&Email=' . $email . '&Code=' . $confirmCode . '" target="_blank">Confirm Account</a> </td>
            </tr>
            </tbody>
        </table>
        </td>
    </tr>
    </tbody>
</table>
<p>Have fun managing your contacts!</p>
';
    return buildBase($mail);
}

?>