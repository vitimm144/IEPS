from django.contrib.auth.admin import UserAdmin
from django.contrib.auth.models import User
from ieps.admin import admin_site


admin_site.register(User, UserAdmin)
# Register your models here.
