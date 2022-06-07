export const MetaCollection = {
    SUPERADMIN: {
        requireAuth: true,
        suitableRoles: ['superadmin']
    },
    ADMIN: {
        requireAuth: true,
        suitableRoles: ['superadmin', 'admin']
    },
    AUTHOR: {
        requireAuth: true,
        suitableRoles: ['superadmin', 'admin', 'author']
    },
    USER: {
        requireAuth: true,
        suitableRoles: ['superadmin', 'admin', 'author', 'user']
    }
}
