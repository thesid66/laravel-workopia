<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0"
	>
	<title>Workopia Job Application</title>
</head>

<body
	style="margin: 0; padding: 0; background-color: #f4f7fb; color: #1f2937; font-family: Arial, Helvetica, sans-serif;"
>
	<table
		role="presentation"
		width="100%"
		cellspacing="0"
		cellpadding="0"
		style="background-color: #f4f7fb; padding: 32px 16px;"
	>
		<tr>
			<td align="center">
				<table
					role="presentation"
					width="100%"
					cellspacing="0"
					cellpadding="0"
					style="max-width: 640px; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;"
				>
					<tr>
						<td style="padding: 28px 32px; background-color: #111827; color: #ffffff;">
							<h1 style="margin: 0; font-size: 24px; line-height: 1.3;">New Job Application</h1>
							<p style="margin: 8px 0 0; color: #d1d5db; font-size: 15px; line-height: 1.5;">
								Someone applied to your Workopia listing.
							</p>
						</td>
					</tr>

					<tr>
						<td style="padding: 28px 32px;">
							<p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
								You received a new application for
								<strong>{{ $job->title ?? 'your job listing' }}</strong>.
							</p>

							<table
								role="presentation"
								width="100%"
								cellspacing="0"
								cellpadding="0"
								style="border-collapse: collapse; margin-bottom: 24px;"
							>
								<tr>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280; width: 160px;">Applicant</td>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
										<strong>{{ data_get($application, 'full_name', 'N/A') }}</strong>
									</td>
								</tr>
								<tr>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;">Email</td>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
										<a
											href="mailto:{{ data_get($application, 'contact_email') }}"
											style="color: #2563eb; text-decoration: none;"
										>{{ data_get($application, 'contact_email', 'N/A') }}</a>
									</td>
								</tr>
								<tr>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;">Phone</td>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
										{{ data_get($application, 'contact_phone', 'N/A') }}</td>
								</tr>
								<tr>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;">Location</td>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
										{{ data_get($application, 'location', 'Not provided') }}</td>
								</tr>
								<tr>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; color: #6b7280;">Job</td>
									<td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">{{ $job->title ?? 'N/A' }}</td>
								</tr>

							</table>

							<h2 style="margin: 0 0 8px; color: #111827; font-size: 18px; line-height: 1.4;">Applicant Message</h2>
							<div
								style="margin: 0 0 24px; padding: 16px; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 15px; line-height: 1.6;"
							>
								{{ data_get($application, 'message', 'No message provided.') }}
							</div>

							@if (data_get($application, 'resume_path'))
								<p style="margin: 0 0 24px;">
									<a
										href="{{ url(data_get($application, 'resume_path')) }}"
										style="display: inline-block; padding: 12px 18px; background-color: #2563eb; color: #ffffff; border-radius: 6px; font-size: 15px; font-weight: bold; text-decoration: none;"
									>
										View Resume
									</a>
								</p>
							@endif

							<p style="margin: 0; color: #4b5563; font-size: 15px; line-height: 1.6;">
								Log in to your Workopia account to view and manage this application.
							</p>
						</td>
					</tr>

					<tr>
						<td style="padding: 20px 32px; background-color: #f9fafb; color: #6b7280; font-size: 13px; line-height: 1.5;">
							This email was sent automatically by Workopia.
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>
