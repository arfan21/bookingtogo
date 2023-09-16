package nationalitydomain

type Nationality struct {
	NationalID   int    `json:"national_id"`
	NationalName string `json:"national_name"`
	NationalCode string `json:"national_code"`
}
