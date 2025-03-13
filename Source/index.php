<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/output.css" rel="stylesheet">
</head>

<body>
    <h1 class="text-bg-danger text-body-emphasis">
        Hello world!
    </h1>
    <div class="text-red-500">Hello Tailwind</div>
    <button type="button" class="collapse-toggle btn btn-primary" id="basic-collapse" aria-expanded="false"
        aria-controls="basic-collapse-heading" data-collapse="#basic-collapse-heading">
        Collapse
        <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
    </button>
    <div id="basic-collapse-heading" class="collapse hidden w-full overflow-hidden transition-[height] duration-300"
        aria-labelledby="basic-collapse">
        <div class="border-base-content/25 mt-3 rounded-md border p-3">
            <p class="text-base-content/80">
                The collapsible body remains concealed by default until the collapse plugin dynamically adds specific
                classes. These classes are instrumental in styling each element, dictating the overall appearance, and
                managing visibility through CSS transitions.
            </p>
        </div>
    </div>
    <div class="flex items-center">
        <span class="icon-[solar--user-bold] size-10"></span>
        <span class="icon-[ic--sharp-account-circle] size-10"></span>
        <span class="icon-[mdi--account-child] size-10"></span>
        <span class="icon-[line-md--account] size-10"></span>
        <span class="icon-[svg-spinners--3-dots-move] size-10"></span>
    </div>
    <script src="../node_modules/flyonui/flyonui.js"></script>
</body>

</html>