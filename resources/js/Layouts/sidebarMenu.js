export const menuGroups =[
    {
        title:'MAIN',
        items:[
            {
                name:'Dashboard',
                icon:'🏠',
                route:'dashboard.index'
            }
        ]
    },
    {
        title:'MANAGEMENT',
        collapsible:true,
        items:[
            {
                name: 'Employees',
                icon: '👥', 
                route: 'employees.index'
            },
            {
                name: 'Attendance', 
                icon: '🕐', 
                route: 'attendance.index'
            },
            {
                name: 'Overtime',
                icon: '⏱️',
                route: 'overtime.index'
            },
            {
                name: 'Leave', 
                icon: '📅', 
                route: 'leave.index' 
            },
            {
                name: 'Shifts', 
                icon: '🕐', 
                route: 'shifts.index'
            },
            // {
            //     name: 'Holidays', 
            //     icon: '📅', 
            //     route: 'holidays.index'
            // }
        ]
    },
    {
        title:'FINANCE',
        collapsible:true,
        items:[
            {
                name: 'Pay Roll', 
                icon: '💰', 
                route: 'payroll.index' 
            },
            {
                name: 'Salary Component', 
                icon: '💰', 
                route: 'salarycomponent.index' 
            },
            {
                name: 'Salary Structure', 
                icon: '💰', 
                route: 'salarystructure.index' 
            },
            {
                name: 'Tax Bracket', 
                icon: '💰', 
                route: 'taxbreacket.index' 
            },
            // {
            //     name: 'Reports', 
            //     icon: '📈', 
            //     route: 'reports.index'
            // }
        ]
    },
    {
        title:'TALENT',
        collapsible:true,
        items:[
            // {
            //      name: 'Recruitment', 
            //      icon: '📋', 
            //      route: 'recruitment.index'
            // },
            // {
            //     name: 'Training', 
            //     icon: '🎓', 
            //     route: 'training.index'
            // },
            // {
            //     name: 'Performance', 
            //     icon: '📊', 
            //     route: 'performance.index'
            // }
        ]
    },
    {
        title:'ADMINISTRATION',
        collapsible:true,
        items:[
            {
                name: 'Users', 
                icon: '👤', 
                route: 'users.index'
            },
            {
                name: 'Roles & Permissions', 
                icon: '🔐', 
                route: 'get_role'
            },
            {
                name: 'Branches', 
                icon: '🏢', 
                route: 'branches.index'
            },
            {
                name: 'Departments', 
                icon: '🏛️', 
                route: 'deparments.index'
            },
            {
                name: 'Positions', 
                icon: '💼', 
                route: 'positions.index' 
            },
            // {
            //     name: 'Settings', 
            //     icon: '⚙️', 
            //     route: 'settings.index' 
            // }
        ]
    }
];

export const roleMenuAccess = {
  'Super Admin': ['Dashboard', 'Management', 'Finance', 'Talent', 'Administration'],
  'HR Manager': ['Dashboard', 'Management', 'Finance', 'Talent'],
  'Department Manager': ['Dashboard', 'Management'],
  'Payroll Officer': ['Dashboard', 'Finance'],
  'Recruitment Officer': ['Dashboard', 'Talent'],
  'Employee': ['Dashboard'],  // Employee → minimalist
};