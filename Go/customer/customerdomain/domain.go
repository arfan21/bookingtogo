package customerdomain

import (
	"encoding/json"
	"time"

	"github.com/arfan21/bookingtogo/constant"
	"github.com/arfan21/bookingtogo/family/familydomain"
	"github.com/arfan21/bookingtogo/nationality/nationalitydomain"
)

type CustomerResponse struct {
	CstID       int                           `json:"-"`
	CstName     string                        `json:"nama"`
	CstDOB      time.Time                     `json:"tanggal_lahir"`
	CstPhoneNum string                        `json:"telepon"`
	CstEmail    string                        `json:"email"`
	NationalID  int                           `json:"-"`
	Family      []familydomain.FamilyResponse `json:"keluarga"`
	Nationality nationalitydomain.Nationality `json:"kewarganegaraan"`
}

func (c *CustomerResponse) MarshalJSON() ([]byte, error) {
	type Alias CustomerResponse
	return json.Marshal(&struct {
		Alias
		CstDOB      string `json:"tanggal_lahir"`
		Nationality string `json:"kewarganegaraan"`
	}{
		Alias:       (Alias)(*c),
		CstDOB:      c.CstDOB.Format(constant.DOBFormat),
		Nationality: c.Nationality.NationalName + " (" + c.Nationality.NationalCode + ")",
	})
}
