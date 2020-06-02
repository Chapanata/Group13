<?php
include 'emailTemplate.php';

function getEmail($confirmCode, $email, $name)
{
    $mail =
'
<p>Hi there,</p>
<p>It appears like you\'ve forgotten your password. Here\'s your reset link:</b></p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="https://jorde.dev/ContactDeluxe/index.php?&Task=Reset&Email=' . $email . '&Code=' . $confirmCode . '" target="_blank">Reset Password</a> </td>
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