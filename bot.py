import os
bd = [
    'CompanyAdministration',
    'CompanySection',
    'CompanyUser',
    'Component',
    'ComponentGroup',
    'Customer',
    'Order',
    'Product',
    'ProductComponent',
    'ProductComponent-Group',
    'ProductComponent-Price',
    'ProductImg',
    'ProductSale',
    'ProductSize-Price',
    'ProductTag',
    'Size',
    'Tag'
]
route = open(r"C:\Users\Dragunov\ABS_Workspace\catalog_patesserie\routes\web.php", "a")

for item in bd:
    print('bot@laravel$ Current Item ['+item+'] :\n')
    os.system('php artisan make:request '+item+'UpdateRequest')

# for item in bd:
#     print('bot@laravel$ Current Item ['+item+'] :\n')

#     print('bot@laravel$ Creating Controller For <'+item+'> :\n')
#     os.system('php artisan make:controller '+item+'Controller --resource')

#     print('bot@laravel$ Creating Request For <'+item+'> :\n')
#     os.system('php artisan make:request '+item+'StoreRequest')

#     print('bot@laravel$ Add Route For <'+item+'>\n')
#     route.write("""\nRoute::resources([
#     '"""+item.lower() + """s' => '""" + item + """Controller',
# ]);\n""")

    # print('bot@laravel$ Creating DIR For <'+item+'> :\n')
    # os.mkdir(item.lower() + 's')
    # for fl in ["index", "create", "edit", "show"]:
    #     f = open(os.getcwd() + "\\" + item.lower() + 's' + "\\" + fl +".blade.php", "w")
    #     f.close()


    
# dirs = os.listdir('.')
# c = open(r"C:\Users\Dragunov\ABS_Workspace\catalog_patesserie\resources\views\includes\e.txt", 'r').readlines()

# for i in dirs:
#     for fl in ["index", "create", "edit", "show"]:
#         f = open(os.getcwd() + "\\" + i + "\\" + fl + ".blade.php", 'w')
#         print(os.getcwd() + "\\" + i + "\\" + fl + ".blade.php")
#         f.writelines(c)
#         f.close()
