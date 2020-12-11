import OrganisationIndex from "./components/Organisation/Index";
import EventIndex from "./components/Event/Index";
import JobIndex from "./components/Job/Index";
import InternshipIndex from "./components/Internship/Index";
import VolunteeringIndex from "./components/Volunteering/Index";
import UserIndex from "./components/User/Index";
import ResumeIndex from "./components/Resume/Index";
import RoleIndex from "./components/Role/Index";
import SettingsIndex from "./components/Settings/Index";
import StatisticsIndex from "./components/Statistics/Index";

export default [
    {
        path: '/',
        redirect: '/organisations',
        name: 'Home',
        component: OrganisationIndex
    },
    {
        path: '/organisations',
        name: 'Organisations',
        component: OrganisationIndex,
    },
    {
        path: '/events',
        name: 'Events',
        component: EventIndex,
    },
    {
        path: '/jobs',
        name: 'Jobs',
        component: JobIndex,
    },
    {
        path: '/internships',
        name: 'Internships',
        component: InternshipIndex,
    },
    {
        path: '/volunteerings',
        name: 'Volunteerings',
        component: VolunteeringIndex,
    },
    {
        path: '/resumes',
        name: 'Resumes',
        component: ResumeIndex,
    },
    {
        path: '/users',
        name: 'Users',
        component: UserIndex,
    },
    {
        path: '/roles',
        name: 'Roles',
        component: RoleIndex,
    },
    {
        path: '/settings',
        name: 'Settings',
        component: SettingsIndex,
    },
    {
        path: '/statistics',
        name: 'Statistics',
        component: StatisticsIndex,
    },
]
