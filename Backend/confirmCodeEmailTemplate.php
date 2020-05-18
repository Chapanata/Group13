<?php
include 'emailTemplate.php';

function getEmail($confirmCode)
{
    $email =
'
<p>Hi there,</p>
<p>Thank you for registering with our platform. Here\'s your confirmation code, <b>' . $confirmCode . '</b></p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="" target="_blank">Confirm Account</a> </td>
            </tr>
            </tbody>
        </table>
        </td>
    </tr>
    </tbody>
</table>
<p>Have fun managing your contacts!</p>
';
    return buildBase($email);
}

?>