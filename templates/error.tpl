{include file='include/header.tpl'}
<div class="container">
    <h1>{if $error->getMessage() !== ''}{$error->getMessage()}{else}An unknown error occurred.{/if}</h1>
    <h4>Error Code: {if $error->getCode() !== ''}{$error->getCode()}{else}500{/if}</h4>
</div>
{include file='include/footer.tpl'}